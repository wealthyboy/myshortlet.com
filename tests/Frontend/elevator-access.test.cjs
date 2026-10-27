const assert = require('node:assert/strict');
const { test } = require('node:test');
const fs = require('node:fs');
const path = require('node:path');
const vm = require('node:vm');
const compiler = require('vue-template-compiler');
const Vue = require('vue');

const root = path.resolve(__dirname, '../..');
const filename = path.join(root, 'resources/js/components/properties/ElevatorAccess.vue');
const source = compiler.parseComponent(fs.readFileSync(filename, 'utf8'));
const compiled = compiler.compileToFunctions(source.template.content);
const context = { module: { exports: {} } };
vm.runInNewContext(source.script.content.replace('export default', 'module.exports ='), context);
const component = { ...context.module.exports, ...compiled };
const text = vnode => [vnode.text || '', ...(vnode.children || []).map(text)].join('');

for (const [label, expected] of [['Elevator Access', 'Elevator Access'], ['Stairs (No Elevator)', 'Stairs (No Elevator)'], [null, ''], [undefined, '']]) {
  test(`renders the existing Accessibility attribute ${String(label)}`, () => {
    const instance = new Vue({ ...component, propsData: { label } });
    assert.equal(text(instance._render()).trim(), expected);
    instance.$destroy();
  });
}

for (const file of ['Apartment.vue', 'IndexApartments.vue']) {
  test(`${file} includes the shared elevator row and compiles`, () => {
    const contents = fs.readFileSync(path.join(root, 'resources/js/components/properties', file), 'utf8');
    assert.ok(contents.includes('<elevator-access :label="room.accessibility_label" />'));
    assert.deepEqual(compiler.compile(compiler.parseComponent(contents).template.content).errors, []);
  });
}

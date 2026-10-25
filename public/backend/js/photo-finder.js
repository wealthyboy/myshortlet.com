(() => {
    'use strict';
    const root = document.getElementById('photo-finder');
    if (!root) return;
    const el = id => document.getElementById(`pf-${id}`);
    const tags = { bedroom: 'Bedroom', living_room: 'Living room', bathroom: 'Bathroom', kitchen: 'Kitchen', dining: 'Dining room', balcony: 'Balcony / terrace', exterior: 'Exterior', other: 'Other' };
    let page = 1, lastPage = 1, searchMode = false, busy = false, stopped = false, previewUrl;
    const notice = (text, type = 'info') => { el('message').textContent = text; el('message').dataset.type = type; el('message').hidden = false; };
    const filters = () => ({ property_id: el('property').value, apartment_id: el('apartment').value, room_tag: el('tag').value, q: el('name').value.trim() });
    const request = async (url, options = {}) => {
        const controller = new AbortController();
        const timeout = setTimeout(() => controller.abort(), 60000);
        try {
            const response = await fetch(url, { credentials: 'same-origin', redirect: 'error', ...options, signal: controller.signal,
                headers: { Accept: 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, ...(options.headers || {}) } });
            const data = await response.json().catch(() => ({}));
            if (!response.ok) {
                const text = response.status === 429 ? 'Please wait a minute before trying again.' : [401, 403, 404, 419].includes(response.status)
                    ? 'Your session expired or you do not have access. Reload this page and sign in again.'
                    : Object.values(data.errors || {}).flat().join(' ') || data.message || 'This request could not be completed. Please retry.';
                throw new Error(`${text}${data.reference ? ` Reference: ${data.reference}` : ''}`);
            }
            return data;
        } finally { clearTimeout(timeout); }
    };
    const node = (tag, className, text) => { const n = document.createElement(tag); if (className) n.className = className; if (text !== undefined) n.textContent = text; return n; };
    const trustedUrl = value => {
        const url = new URL(value, window.location.href);
        if (!['http:', 'https:'].includes(url.protocol)) throw new Error('An unsupported photo link was returned.');
        return url.href;
    };
    const render = photos => {
        el('grid').replaceChildren(); el('empty').hidden = photos.length > 0;
        for (const photo of photos) {
            const card = node('article', 'pf-card');
            const link = node('a', 'pf-photo-link'); link.href = trustedUrl(photo.url); link.target = '_blank'; link.rel = 'noopener noreferrer';
            const img = node('img'); img.src = trustedUrl(photo.thumbnail_url || photo.url); img.alt = `${photo.apartment_name}${photo.caption ? ` — ${photo.caption}` : ''}`; img.loading = 'lazy';
            img.addEventListener('error', () => { img.src = link.href; }, { once: true });
            link.append(img);
            if (photo.score !== null) link.append(node('span', 'pf-score', `${photo.score >= 86 ? 'Similar photo' : 'Compare manually'} · ${photo.score}/100`));
            const body = node('div', 'pf-card-body');
            body.append(node('div', 'pf-property', photo.property_name || 'Apartment gallery'), node('h3', '', photo.apartment_name), node('div', 'pf-photo-id', `Apartment #${photo.apartment_id} · Photo #${photo.id}`));
            if (photo.caption) body.append(node('p', 'pf-caption', photo.caption));
            const label = node('label', 'pf-tag-label', 'Room tag'); label.htmlFor = `photo-tag-${photo.id}`;
            const select = node('select', 'pf-tag-select'); select.id = label.htmlFor;
            select.append(new Option('Not tagged yet', ''));
            Object.entries(tags).forEach(([value, text]) => select.append(new Option(text, value)));
            select.value = photo.room_tag || '';
            select.addEventListener('change', async () => {
                const previous = photo.room_tag; select.disabled = true;
                try {
                    const result = await request(photo.tag_url, { method: 'PATCH', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ room_tag: select.value || null }) });
                    photo.room_tag = result.room_tag; notice(`Tag saved for ${photo.apartment_name}.`);
                } catch (error) { select.value = previous || ''; notice(error.message, 'error'); }
                finally { select.disabled = false; }
            });
            body.append(label, select);
            const actions = node('div', 'pf-card-actions'); const edit = node('a', '', 'Open apartment ↗'); edit.href = trustedUrl(photo.edit_url); edit.target = '_blank'; edit.rel = 'noopener noreferrer';
            const copy = node('button', 'pf-link', 'Copy name'); copy.type = 'button';
            copy.addEventListener('click', async () => { try { await navigator.clipboard.writeText(photo.apartment_name); notice('Apartment name copied.'); } catch { notice(`Apartment: ${photo.apartment_name}`); } });
            actions.append(edit, copy); body.append(actions); card.append(link, body); el('grid').append(card);
        }
        el('prev').disabled = busy || searchMode || page <= 1; el('next').disabled = busy || searchMode || page >= lastPage;
        el('page').textContent = searchMode ? 'Closest photos first · similarity is not certainty' : `Page ${page} of ${lastPage}`;
    };
    const load = async () => {
        if (searchMode) {
            const file = el('photo').files[0];
            if (!file) throw new Error('Choose a reference photo first.');
            if (file.size > 8 * 1024 * 1024) throw new Error('Choose a photo smaller than 8 MB.');
            const body = new FormData(); body.append('photo', file); Object.entries(filters()).forEach(([key, value]) => body.append(key, value));
            const data = await request(root.dataset.searchUrl, { method: 'POST', body });
            el('results-heading').textContent = 'Compare possible matches';
            el('summary').textContent = `${data.indexed} of ${data.total} filtered photos compared. ${data.close_match ? 'Closest visual matches are shown first.' : 'No close match found. These are suggestions to compare manually.'}`;
            render(data.photos);
            if (data.indexed < data.total) notice(`${data.total - data.indexed} photos are not prepared yet. Use “Prepare photo search” to include them.`, 'info');
        } else {
            const data = await request(`${root.dataset.galleryUrl}?${new URLSearchParams({ ...filters(), page })}`);
            lastPage = data.last_page; el('results-heading').textContent = 'Photo library'; el('summary').textContent = `${data.total} apartment photos · use room tags to narrow your search.`; render(data.photos);
        }
    };
    const run = async task => {
        if (busy) return; busy = true; el('grid').setAttribute('aria-busy', 'true');
        const controls = [...root.querySelectorAll('button, input, select')].filter(n => n.id !== 'pf-stop');
        const disabled = controls.map(n => n.disabled); controls.forEach(n => { n.disabled = true; });
        try { await task(); }
        catch (error) { notice(error.name === 'AbortError' ? 'This request took too long. Please retry; your gallery is unchanged.' : error.message, 'error'); }
        finally {
            busy = false; controls.forEach((n, i) => { if (n.isConnected) n.disabled = disabled[i]; });
            el('grid').setAttribute('aria-busy', 'false'); el('prev').disabled = searchMode || page <= 1; el('next').disabled = searchMode || page >= lastPage;
        }
    };
    el('photo').addEventListener('change', () => {
        if (previewUrl) URL.revokeObjectURL(previewUrl);
        const file = el('photo').files[0]; el('preview-wrap').hidden = !file;
        if (file) { previewUrl = URL.createObjectURL(file); el('preview').src = previewUrl; el('filename').textContent = file.name; }
    });
    el('search').addEventListener('click', () => run(async () => { searchMode = true; page = 1; await load(); }));
    el('browse').addEventListener('click', () => run(async () => { searchMode = false; page = 1; await load(); }));
    el('filter').addEventListener('click', () => run(async () => { page = 1; await load(); }));
    el('clear').addEventListener('click', () => run(async () => { ['property', 'apartment', 'tag', 'name'].forEach(id => { el(id).value = ''; }); limitApartments(); page = 1; await load(); }));
    el('name').addEventListener('keydown', event => { if (event.key === 'Enter') { event.preventDefault(); el('filter').click(); } });
    const limitApartments = () => {
        for (const option of el('apartment').options) option.hidden = !!option.value && !!el('property').value && option.dataset.property !== el('property').value;
        if (el('apartment').selectedOptions[0]?.hidden) el('apartment').value = '';
    };
    el('property').addEventListener('change', limitApartments); limitApartments();
    el('prev').addEventListener('click', () => run(async () => { page--; await load(); }));
    el('next').addEventListener('click', () => run(async () => { page++; await load(); }));
    el('stop').addEventListener('click', () => { stopped = true; el('stop').disabled = true; });
    el('prepare').addEventListener('click', () => run(async () => {
        let after = 0, processed = 0, indexed = 0, failed = 0, reference;
        stopped = false; el('stop').hidden = false; el('stop').disabled = false;
        try {
            do {
                const data = await request(root.dataset.prepareUrl, { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ ...filters(), after_id: after }) });
                after = data.after_id; processed += data.processed; indexed += data.indexed; failed += data.failed; reference = data.reference || reference;
                el('progress').textContent = `${processed} checked · ${indexed} prepared · ${failed} unavailable`;
                if (data.done || stopped) break;
                await new Promise(resolve => setTimeout(resolve, 1100));
            } while (!stopped);
            notice(`${stopped ? 'Preparation paused.' : 'Photo search prepared.'} ${indexed} new fingerprints. ${failed ? `${failed} photos could not be read; you can retry. Reference: ${reference}` : 'Your original photos are unchanged.'}`, failed ? 'error' : 'info');
        } finally { el('stop').hidden = true; }
        await load();
    }));
    run(load);
})();

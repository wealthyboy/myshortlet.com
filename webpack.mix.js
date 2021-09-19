const mix = require("laravel-mix");

mix.js("resources/js/services.js", "public/js/services_js.js").vue();
mix.sass("resources/css/services.scss", "public/css/services_style.css");
mix.sass(
  "resources/css/user_account_scss/account.scss",
  "public/css/account_styles.css"
);

mix.styles(
  [
    "public/backend/css/bootstrap.min.css",
    "public/backend/css/dashboard.css",
    "public/backend/css/custom.css",
    "public/backend/css/slick.css",
  ],
  "public/backend/css/admin.css"
);

mix.scripts(
  [
    "public/backend/js/bootstrap.min.js",
    "public/backend/js/material.min.js",
    "public/backend/js/jquery.validate.min.js",
    "public/backend/js/material-dashboard-v=1.3.0.js",
    "public/backend/js/jquery.bootstrap-wizard.js",
    "public/backend/js/moment.min.js",
    "public/backend/js/bootstrap-datetimepicker.js",
    "public/backend/js/scripts.js",
  ],
  "public/backend/js/dashboard.js"
);

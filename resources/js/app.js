import "./bootstrap";
import { createApp, h } from "vue";
import { createInertiaApp, Link, Head, router, usePage } from "@inertiajs/vue3";
import { createPinia } from "pinia";
import timeago from "vue-timeago3";

import PerfectScrollbar from "vue3-perfect-scrollbar";
import "vue3-perfect-scrollbar/dist/vue3-perfect-scrollbar.css";

import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/index";
const pinia = createPinia();
import { defineAsyncComponent } from "vue";

import Toaster from "./helpers/Toaster"; //--for 'globally' use
window.toaster = Toaster;

import Service from "./helpers/service"; //--for 'globally' use
window.service = Service;

import SweetAlert from "./helpers/SweetAlert"; //--for 'globally' use
window.sw = SweetAlert;

import emitter from "tiny-emitter/instance";
window.emit = emitter;

import CKEditor from "@ckeditor/ckeditor5-vue";

const AdminLayout = defineAsyncComponent(() =>
  import("./Layout/Admin/Layout.vue")
);

import { autoAnimatePlugin } from "@formkit/auto-animate/vue";

import { Icon } from "@iconify/vue";
import timepicker from "vue3-time-picker-plugin";
import "vue3-time-picker-plugin/dist/style.css";

router.on("finish", () => {
  if (usePage().props.flash.success) {
    toaster.success(usePage().props.flash.success);
  }

  if (usePage().props.flash.error) {
    toaster.error(usePage().props.flash.error);
  }
  if (usePage().props.flash.warning) {
    toaster.warning(usePage().props.flash.warning);
  }

  if (usePage().props.flash.info) {
    toaster.info(usePage().props.flash.info);
  }
});

createInertiaApp({
  progress: {
    color: "#29d",
    includeCSS: true,
    showSpinner: false,
  },

  title: (title) => `${title} - MTLI`,
  resolve: async (name) => {
    const pages = import.meta.glob("./Pages/**/*.vue", { eager: false });
    let page = await pages[`./Pages/${name}.vue`]();

    if (name.startsWith("Admin/")) {
      page.default.layout = AdminLayout;
    }

    return page;
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(pinia)
      .use(CKEditor)
      .use(autoAnimatePlugin)
      .use(PerfectScrollbar)
      .use(timeago)
      .use(timepicker)
      .use(ZiggyVue, Ziggy)
      .component("Link", Link)
      .component("Head", Head)
      .component("Icon", Icon)
      .mount(el);
  },
});

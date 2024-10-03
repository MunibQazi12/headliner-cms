const Ziggy = {
  url: "http://localhost",
  port: null,
  defaults: {},
  routes: {
    "sanctum.csrf-cookie": {
      uri: "sanctum/csrf-cookie",
      methods: ["GET", "HEAD"],
    },
    "ignition.healthCheck": {
      uri: "_ignition/health-check",
      methods: ["GET", "HEAD"],
    },
    "ignition.executeSolution": {
      uri: "_ignition/execute-solution",
      methods: ["POST"],
    },
    "ignition.updateConfig": {
      uri: "_ignition/update-config",
      methods: ["POST"],
    },
    "admin.forgotPassword": {
      uri: "admin/forgot-password",
      methods: ["GET", "HEAD", "POST", "PUT", "PATCH", "DELETE", "OPTIONS"],
    },
    "admin.otpValidations": {
      uri: "admin/otp-validations",
      methods: ["GET", "HEAD", "POST", "PUT", "PATCH", "DELETE", "OPTIONS"],
    },
    "admin.resetPassword": {
      uri: "admin/reset-password",
      methods: ["GET", "HEAD", "POST", "PUT", "PATCH", "DELETE", "OPTIONS"],
    },
    "admin.login": { uri: "admin/login", methods: ["GET", "HEAD"] },
    login: { uri: "admin/login", methods: ["POST"] },
    "admin.dashboard": { uri: "admin/dashboard", methods: ["GET", "HEAD"] },
    "admin.profile": {
      uri: "admin/admin-profile",
      methods: ["GET", "HEAD", "POST", "PUT", "PATCH", "DELETE", "OPTIONS"],
    },
    "admin.changePassword": {
      uri: "admin/admin-change-password",
      methods: ["POST"],
    },
    "admin.logout": { uri: "admin/logout", methods: ["POST"] },
    "admin.users": { uri: "admin/user", methods: ["GET", "HEAD"] },
    "admin.createUser": {
      uri: "admin/create-user",
      methods: ["GET", "HEAD", "POST", "PUT", "PATCH", "DELETE", "OPTIONS"],
    },
    "admin.editUser": {
      uri: "admin/edit-user/{id}",
      methods: ["GET", "HEAD", "POST", "PUT", "PATCH", "DELETE", "OPTIONS"],
      parameters: ["id"],
    },
    "admin.userDelete": {
      uri: "admin/delete-user/{id}",
      methods: ["DELETE"],
      parameters: ["id"],
    },
    "admin.changeuserstatus": {
      uri: "admin/change-user-status",
      methods: ["POST"],
    },
    "admin.blog.index": { uri: "admin/blogs", methods: ["GET", "HEAD"] },
    "admin.blog.create": {
      uri: "admin/create-blog",
      methods: ["GET", "HEAD", "POST", "PUT", "PATCH", "DELETE", "OPTIONS"],
    },
    "admin.blog.edit": {
      uri: "admin/edit-blog/{id}/edit",
      methods: ["GET", "HEAD", "POST", "PUT", "PATCH", "DELETE", "OPTIONS"],
      parameters: ["id"],
    },
    "admin.blog.destroy": {
      uri: "admin/delete-blog/{id}",
      methods: ["DELETE"],
      parameters: ["id"],
    },
    "admin.blog.status": { uri: "admin/change-blog-status", methods: ["POST"] },
    "admin.category.index": { uri: "admin/category", methods: ["GET", "HEAD"] },
    "admin.category.create": {
      uri: "admin/category/create",
      methods: ["GET", "HEAD"],
    },
    "admin.category.store": { uri: "admin/category", methods: ["POST"] },
    "admin.category.show": {
      uri: "admin/category/{category}",
      methods: ["GET", "HEAD"],
      parameters: ["category"],
    },
    "admin.category.edit": {
      uri: "admin/category/{category}/edit",
      methods: ["GET", "HEAD"],
      parameters: ["category"],
      bindings: { category: "id" },
    },
    "admin.category.destroy": {
      uri: "admin/category/{category}",
      methods: ["DELETE"],
      parameters: ["category"],
      bindings: { category: "id" },
    },
    "admin.category.update": {
      uri: "admin/category/{category}",
      methods: ["POST"],
      parameters: ["category"],
      bindings: { category: "id" },
    },
    "admin.category.status": {
      uri: "admin/change-category-status",
      methods: ["POST"],
    },
    "admin.products.index": { uri: "admin/products", methods: ["GET", "HEAD"] },
    "admin.products.create": {
      uri: "admin/products/create",
      methods: ["GET", "HEAD"],
    },
    "admin.products.store": { uri: "admin/products", methods: ["POST"] },
    "admin.products.edit": {
      uri: "admin/products/{product}/edit",
      methods: ["GET", "HEAD"],
      parameters: ["product"],
    },
    "admin.products.destroy": {
      uri: "admin/products/{product}",
      methods: ["DELETE"],
      parameters: ["product"],
      bindings: { product: "id" },
    },
    "admin.products.update": {
      uri: "admin/products/{id}",
      methods: ["POST"],
      parameters: ["id"],
    },
    "admin.products.status": {
      uri: "admin/change-products-status",
      methods: ["POST"],
    },
    "admin.cms.index": { uri: "admin/cms", methods: ["GET", "HEAD"] },
    "admin.cms.create": { uri: "admin/cms/create", methods: ["GET", "HEAD"] },
    "admin.cms.store": { uri: "admin/cms", methods: ["POST"] },
    "admin.cms.edit": {
      uri: "admin/cms/{cm}/edit",
      methods: ["GET", "HEAD"],
      parameters: ["cm"],
    },
    "admin.cms.destroy": {
      uri: "admin/cms/{cm}",
      methods: ["DELETE"],
      parameters: ["cm"],
    },
    "admin.": {
      uri: "admin/cms/{slug}",
      methods: ["POST"],
      parameters: ["slug"],
    },
    "log-viewer::dashboard": { uri: "log-viewer", methods: ["GET", "HEAD"] },
    "log-viewer::logs.list": {
      uri: "log-viewer/logs",
      methods: ["GET", "HEAD"],
    },
    "log-viewer::logs.delete": {
      uri: "log-viewer/logs/delete",
      methods: ["DELETE"],
    },
    "log-viewer::logs.show": {
      uri: "log-viewer/logs/{date}",
      methods: ["GET", "HEAD"],
      parameters: ["date"],
    },
    "log-viewer::logs.download": {
      uri: "log-viewer/logs/{date}/download",
      methods: ["GET", "HEAD"],
      parameters: ["date"],
    },
    "log-viewer::logs.filter": {
      uri: "log-viewer/logs/{date}/{level}",
      methods: ["GET", "HEAD"],
      parameters: ["date", "level"],
    },
    "log-viewer::logs.search": {
      uri: "log-viewer/logs/{date}/{level}/search",
      methods: ["GET", "HEAD"],
      parameters: ["date", "level"],
    },
  },
};
if (typeof window !== "undefined" && typeof window.Ziggy !== "undefined") {
  Object.assign(Ziggy.routes, window.Ziggy.routes);
}
export { Ziggy };

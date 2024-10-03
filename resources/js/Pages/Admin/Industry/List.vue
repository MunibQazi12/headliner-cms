<template>
  <div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__body">
      <div
        id="kt_table_1_wrapper"
        class="dataTables_wrapper dt-bootstrap4 no-footer"
      >
        <div class="row">
          <div class="col-sm-12 col-md-6">
            <perPageDropdown />
          </div>
          <div class="col-sm-12 col-md-6">
            <!-- <div id="kt_table_1_filter" class="dataTables_filter">
                            <Link :href="route('admin.industry.create')" class="btn btn-primary"><i
                                class="la la-plus"></i>Add New
                            </Link>
                        </div> -->
          </div>
        </div>

        <div class="row table-responsive table_fixed_width">
          <div class="col-sm-12">
            <table
              class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline"
              id="kt_table_1"
              role="grid"
              aria-describedby="kt_table_1_info"
              style="width: 1115px"
            >
              <thead>
                <tr role="row">
                  <th
                    tabindex="0"
                    aria-controls="kt_table_1"
                    rowspan="1"
                    colspan="1"
                    style="width: 50%"
                    aria-sort="ascending"
                    aria-label="Agent: activate to sort column descending"
                  >
                    Title
                  </th>
                  <th
                    tabindex="0"
                    aria-controls="kt_table_1"
                    rowspan="1"
                    colspan="1"
                    style="width: 30%"
                    aria-sort="ascending"
                    aria-label="Agent: activate to sort column descending"
                  >
                    Slug
                  </th>
                  <th
                    tabindex="0"
                    aria-controls="kt_table_1"
                    rowspan="1"
                    colspan="1"
                    style="width: 30%"
                    aria-sort="ascending"
                    aria-label="Agent: activate to sort column descending"
                  >
                    Status
                  </th>

                  <th
                    tabindex="0"
                    aria-controls="kt_table_1"
                    rowspan="1"
                    colspan="1"
                    style="width: 20%"
                    aria-sort="ascending"
                    aria-label="Agent: activate to sort column descending"
                  >
                    Actions
                  </th>
                </tr>
                <tr class="filter">
                  <th>
                    <input
                      type="search"
                      v-model="form.searchTitle"
                      placeholder=""
                      autocomplete="off"
                      class="form-control-sm form-filter"
                    />
                  </th>
                  <th>
                    <input
                      type="search"
                      v-model="form.searchSlug"
                      placeholder=""
                      autocomplete="off"
                      class="form-control-sm form-filter"
                    />
                  </th>
                  <th>
                    <select
                      class="form-control form-control-sm form-filter kt-input"
                      v-model="form.searchStatus"
                      title="Select"
                      data-col-index="2"
                    >
                      <option value="">Select One</option>
                      <option value="1">Live</option>
                      <option value="0">Inactive</option>
                    </select>
                  </th>
                  <th>
                    <div class="row justify-content-center align-items-center">
                      <div class="col-md-6">
                        <button
                          class="btn btn-brand kt-btn btn-sm kt-btn--icon button-fx cmnBtn"
                          @click="search"
                        >
                          <span>
                            <i class="la la-search"></i>
                            <span>Search</span>
                          </span>
                        </button>
                      </div>
                      <div class="col-md-6">
                        <button
                          class="btn btn-secondary kt-btn btn-sm kt-btn--icon button-fx cmnBtnTw"
                          @click="resetSearch"
                        >
                          <span>
                            <i class="la la-close"></i>
                            <span>Reset</span>
                          </span>
                        </button>
                      </div>
                    </div>
                  </th>
                </tr>
              </thead>
              <tbody v-auto-animate>
                <tr
                  role="row"
                  class="odd"
                  v-for="item in industries.data"
                  :key="item.id"
                >
                  <td>
                    {{ item.title }}
                  </td>
                  <td>
                    <Link :href="`industry-edit/${item.id}`"
                      >{{ item.slug != null ? item.slug : "Enter Slug" }}
                    </Link>
                  </td>

                  <td>
                    <span
                      @click="changeStatus(item.id)"
                      style="cursor: pointer"
                      class="kt-badge kt-badge--inline kt-badge--pill cursor-pointer"
                      :class="
                        item.status == 1
                          ? 'kt-badge--success'
                          : 'kt-badge--warning'
                      "
                      >{{ item.status == 1 ? "Live" : "Inactive" }}</span
                    >
                  </td>

                  <td nowrap="" class="align-center">
                    <span class="dropdown">
                      <a
                        href="#"
                        class="btn btn-sm btn-clean btn-icon btn-icon-md"
                        data-toggle="dropdown"
                        aria-expanded="true"
                      >
                        <i class="la la-ellipsis-h"></i>
                      </a>
                      <div class="dropdown-menu dropdown-menu-right">
                        <Link
                          class="dropdown-item"
                          :href="`industry-edit/${item.id}`"
                          ><i class="la la-edit"></i> Edit</Link
                        >
                        <button
                          href="#"
                          class="dropdown-item"
                          @click="deleteRecode(item.id)"
                        >
                          <i class="fa fa-trash"></i> Delete
                        </button>
                      </div>
                    </span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="col-sm-12" v-if="industries.total == 0">
            <div class="no_data text-center">
              <h3>No data Found</h3>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12 col-md-5">
            <div
              class="dataTables_info"
              id="kt_table_1_info"
              role="status"
              aria-live="polite"
            >
              Showing {{ industries.from }} to {{ industries.to }} of
              {{ industries.total }} entries
            </div>
          </div>
          <div class="col-sm-12 col-md-7">
            <div class="float-right">
              <Bootstrap4Pagination
                :data="industries"
                :limit="2"
                @pagination-change-page="ListHelper.setPageNum"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Bootstrap4Pagination } from "laravel-vue-pagination";
import { router, useForm } from "@inertiajs/vue3";
import { ref, onMounted, onUnmounted } from "vue";
import Datepicker from "../../../components/Datepicker.vue";
import ListHelper from "../../../helpers/ListHelper";
import perPageDropdown from "@/components/PerpageDropdown.vue";

const props = defineProps({
  industries: Object,
});

let params = new URLSearchParams(window.location.search);

const form = useForm({
  searchTitle: params.get("title") || null,
  searchSlug: params.get("slug") || null,
  searchStatus: params.get("status") || "",
});

onMounted(() => {
  emit.emit("pageName", "Industry Management", [
    {
      title: "All Industry",
      routeName: "admin.industry",
    },
  ]);

  emit.on("deleteConfirm", function (arg1) {
    deleteConfirm(arg1);
  });

  emit.on("changeStatusConfirm", function (arg1) {
    changeStatusConfirm(arg1);
  });
});

onUnmounted(() => {
  emit.off("changeStatusConfirm");
  emit.off("deleteConfirm");
});

const changeStatus = (id) => {
  sw.confirm(
    "changeStatusConfirm",
    id,
    "Are you sure?",
    "You want to change the status!",
    "Yes, Change it!"
  );
};

const changeStatusConfirm = (id) => {
  let data = {
    id: id,
  };
  router.post(route("admin.industry.status"), data);
};

const resetSearch = () => {
  router.visit(route("admin.industry"), {
    method: "get",
  });
};

const search = () => {
  let data = {
    title: form.searchTitle,
    slug: form.searchSlug,
    status: form.searchStatus,
  };

  if (form.searchTitle == "" || form.searchTitle == null) {
    delete data.title;
  }
  if (form.searchSlug == "" || form.searchSlug == null) {
    delete data.slug;
  }
  if (form.searchStatus == "" || form.searchStatus == null) {
    delete data.status;
  }

  router.visit(route("admin.industry"), {
    method: "get",
    data: data,
    replace: false,
  });
};

const deleteRecode = (id) => {
  sw.confirm("deleteConfirm", id);
};

const deleteConfirm = (id) => {
  router.post(route("admin.industry.delete", id));
};
</script>

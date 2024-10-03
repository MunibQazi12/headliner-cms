<template lang="">
  <div>
    <Head title="User List" />
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
                                <Link :href="route('admin.create-choose-for')" class="btn btn-primary"><i class="la la-plus"></i>Add New</Link>
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
                      style="width: 60%"
                      aria-sort="ascending"
                      aria-label="Agent: activate to sort column descending"
                    >
                      Title
                      <i
                        class="fa fa-fw fa-sort pull-right"
                        style="cursor: pointer"
                        @click="ListHelper.sortBy('title')"
                      ></i>
                    </th>
                    <th
                      class="align-center"
                      tabindex="0"
                      aria-controls="kt_table_1"
                      rowspan="1"
                      colspan="1"
                      style="width: 20%"
                      aria-label="Status: activate to sort column ascending"
                    >
                      Status
                    </th>
                    <th
                      class="align-center"
                      rowspan="1"
                      colspan="1"
                      style="width: 20%"
                      aria-label="Actions"
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
                      <div
                        class="row justify-content-center align-items-center"
                      >
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
                    v-for="choose in props.chooseFor.data"
                    :key="choose.id"
                  >
                    <td>{{ choose.title }}</td>
                    <td class="align-center">
                      <span
                        @click="changeStatus(choose.id)"
                        style="cursor: pointer"
                        class="kt-badge kt-badge--inline kt-badge--pill cursor-pointer"
                        :class="
                          choose.status == 1
                            ? 'kt-badge--success'
                            : 'kt-badge--warning'
                        "
                        >{{ choose.status == 1 ? "Live" : "Inactive" }}</span
                      >
                    </td>
                    <td nowrap="" class="align-center">
                      <span class="dropdown">
                        <a
                          href="#"
                          class="btn btn-sm btn-clean btn-icon btn-icon-md"
                          data-toggle="dropdown"
                        >
                          <i class="la la-ellipsis-h"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                          <Link
                            class="dropdown-item"
                            :href="route('admin.edit-choose-for', choose.id)"
                            ><i class="la la-edit"></i> Edit</Link
                          >
                          <button
                            href="#"
                            class="dropdown-item"
                            @click="deleteRecode(choose.id)"
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
            <div class="col-sm-12" v-if="chooseFor.total == 0">
              <div class="no_data text-center">
                <h3>No data Found</h3>
              </div>
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
              Showing {{ chooseFor.from }} to {{ chooseFor.to }} of
              {{ chooseFor.total }} entries
            </div>
          </div>
          <div class="col-sm-12 col-md-7">
            <div class="float-right">
              <Bootstrap4Pagination
                :data="chooseFor"
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
import { router } from "@inertiajs/vue3";
import { useForm } from "@inertiajs/vue3";
import { ref, watch, reactive, onMounted, onUnmounted } from "vue";
import { Bootstrap4Pagination } from "laravel-vue-pagination";
import service from "../../../helpers/service";
import ListHelper from "../../../helpers/ListHelper";
import perPageDropdown from "@/components/PerpageDropdown.vue";

const props = defineProps({
  chooseFor: Array,
});
let params = new URLSearchParams(window.location.search);

const form = useForm({
  searchTitle: params.get("title") || null,
  searchStatus: params.get("status") || "",
});

onMounted(() => {
  emit.emit("pageName", "Resource Management", [
    {
      title: "Choose For List",
      routeName: "admin.choose-for",
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

const resetSearch = () => {
  router.visit(route("admin.choose-for"), {
    method: "get",
  });
};

const search = () => {
  let data = {
    title: form.searchTitle,
    status: form.searchStatus,
  };
  if (form.searchTitle == "" || form.searchTitle == null) {
    delete data.title;
  }
  if (form.searchStatus == "" || form.searchStatus == null) {
    delete data.status;
  }

  router.visit(route("admin.choose-for"), {
    method: "get",
    data: data,
    replace: false,
  });
};

const deleteRecode = (id) => {
  sw.confirm("deleteConfirm", id);
};

const deleteConfirm = (id) => {
  router.delete(route("admin.choose-for-Delete", id));
};

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
  router.post(route("admin.change-choose-for-status"), data);
};
</script>
<style lang=""></style>

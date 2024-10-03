<template lang="">
  <div>
    <Head title="Products List" />
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
                                <Link :href="route('admin.dry.ice.create')" class="btn btn-primary"><i class="la la-plus"></i>Add New</Link>
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
                      style="width: 30%"
                      aria-sort="ascending"
                      aria-label="Agent: activate to sort column descending"
                    >
                      Slug
                      <i
                        class="fa fa-fw fa-sort pull-right"
                        style="cursor: pointer"
                        @click="ListHelper.sortBy('slug')"
                      ></i>
                    </th>
                    <th
                      tabindex="0"
                      aria-controls="kt_table_1"
                      rowspan="1"
                      colspan="1"
                      style="width: 15%"
                    >
                      Created at
                      <i
                        class="fa fa-fw fa-sort pull-right"
                        style="cursor: pointer"
                        @click="ListHelper.sortBy('created_at')"
                      ></i>
                    </th>
                    <th
                      class="align-center"
                      tabindex="0"
                      aria-controls="kt_table_1"
                      rowspan="1"
                      colspan="1"
                      style="width: 25%"
                      aria-label="Status: activate to sort column ascending"
                    >
                      Status
                      <!-- <i class="fa fa-fw fa-sort pull-right" style="cursor: pointer" @click="ListHelper.sortBy('status')"></i> -->
                    </th>
                    <th
                      class="align-center"
                      rowspan="1"
                      colspan="1"
                      style="width: 15%"
                      aria-label="Actions"
                    >
                      Actions
                    </th>
                  </tr>

                  <tr class="filter">
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
                      <input
                        type="date"
                        v-model="form.searchDate"
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
                        <option value="1">Active</option>
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
                    v-for="ice in props.dryice.data"
                    :key="ice.id"
                  >
                    <td>
                      <Link :href="route('admin.edit.dry.ice', ice.id)">{{
                        ice.slug == null ? "Enter Slug" : ice.slug
                      }}</Link>
                    </td>

                    <td>
                      {{
                        ListHelper.dateFormat(ice.created_at, "MMM DD, YYYY")
                      }}
                    </td>
                    <td class="align-center">
                      <span
                        class="kt-badge kt-badge--inline kt-badge--pill cursor-pointer"
                        :class="
                          ice.status == 1
                            ? 'kt-badge--success'
                            : 'kt-badge--warning'
                        "
                        >{{ ice.status == 1 ? "Live" : "Inactive" }}</span
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
                            :href="route('admin.edit.dry.ice', ice.id)"
                            ><i class="la la-edit"></i> Edit</Link
                          >
                          <!-- <button href="#" class="dropdown-item" @click="deleteRecode(ice.id)">
                                                        <i class="fa fa-trash"></i> Delete
                                                    </button> -->
                        </div>
                      </span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="col-sm-12" v-if="props.dryice.data.length == 0">
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
              Showing {{ dryice.from }} to {{ dryice.to }} of
              {{ dryice.total }} entries
            </div>
          </div>
          <div class="col-sm-12 col-md-7">
            <div class="float-right">
              <Bootstrap4Pagination
                :data="dryice"
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
  dryice: Object,
  shortBy: String,
});

let params = new URLSearchParams(window.location.search);

const form = useForm({
  searchName: params.get("name") || null,
  searchStatus: params.get("active") || "",
  searchDate: params.get("created_at") || "",
});

onMounted(() => {
  emit.emit("pageName", "Dry Ice Management", [
    {
      title: "All Dry Ice",
      routeName: "admin.dry.ice.list",
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
  router.visit(route("admin.dry.ice.list"), {
    method: "get",
  });
};

const search = () => {
  let data = {
    name: form.searchName,
    active: form.searchStatus,
    slug: form.searchSlug,
    created_at: form.searchDate,
  };
  if (form.searchName == "" || form.searchName == null) {
    delete data.name;
  }
  if (form.searchSlug == "" || form.searchSlug == null) {
    delete data.slug;
  }
  if (form.searchStatus == "" || form.searchStatus == null) {
    delete data.active;
  }
  if (form.searchDate == "" || form.searchDate == null) {
    delete data.created_at;
  }

  router.visit(route("admin.dry.ice.list"), {
    method: "get",
    data: data,
    replace: false,
  });
};

const deleteRecode = (id) => {
  sw.confirm("deleteConfirm", id);
};

const deleteConfirm = (id) => {
  router.delete(route("admin.delete.dry.ice", id));
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
  router.post(route("admin.changeProductStatus"), data);
};
</script>
<style lang=""></style>

<style lang=""></style>

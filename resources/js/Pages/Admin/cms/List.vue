<template lang="">
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
            <div id="kt_table_1_filter" class="dataTables_filter"></div>
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
                    style="width: 80%"
                    aria-sort="ascending"
                    aria-label="Agent: activate to sort column descending"
                  >
                    Page Name
                    <i
                      class="fa fa-fw fa-sort pull-right"
                      style="cursor: pointer"
                      @click="ListHelper.sortBy('title')"
                    ></i>
                  </th>
                  <th
                    tabindex="0"
                    aria-controls="kt_table_1"
                    rowspan="1"
                    colspan="1"
                    style="width: 80%"
                    aria-sort="ascending"
                    aria-label="Agent: activate to sort column descending"
                  >
                    Slug
                    <i
                      class="fa fa-fw fa-sort pull-right"
                      style="cursor: pointer"
                      @click="ListHelper.sortBy('title')"
                    ></i>
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
                    <input
                      type="search"
                      v-model="form.searchSlug"
                      placeholder=""
                      autocomplete="off"
                      class="form-control-sm form-filter"
                    />
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
                  v-for="page in pages.data"
                  :key="page.id"
                >
                  <td class="sorting_1" tabindex="0">
                    {{ page.title }}
                  </td>
                  <td class="sorting_1" tabindex="0">
                    <Link :href="`cms/page/${page.slug}/edit`">{{
                      page.slug
                    }}</Link>
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
                          :href="`cms/page/${page.slug}/edit`"
                          ><i class="la la-edit"></i> Edit</Link
                        >
                      </div>
                    </span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="col-sm-12" v-if="pages.total == 0">
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
            Showing {{ pages.from }} to {{ pages.to }} of
            {{ pages.total }} entries
          </div>
        </div>
        <div class="col-sm-12 col-md-7">
          <div class="float-right">
            <Bootstrap4Pagination
              :data="pages"
              :limit="2"
              @pagination-change-page="ListHelper.setPageNum"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Bootstrap4Pagination } from "laravel-vue-pagination";
import { router, useForm } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";
import Datepicker from "../../../components/Datepicker.vue";
import ListHelper from "../../../helpers/ListHelper";
import perPageDropdown from "@/components/PerpageDropdown.vue";

const props = defineProps({
  pages: Object,
  shortBy: String,
});

let params = new URLSearchParams(window.location.search);

const form = useForm({
  searchTitle: params.get("title") || null,
  searchSlug: params.get("slug") || null,
});

onMounted(() => {
  emit.emit("pageName", "Content Management", [
    {
      title: "All Pages",
      routeName: "admin.cms.index",
    },
  ]);
});

const resetSearch = () => {
  router.visit("/admin/cms", {
    method: "get",
  });
};

const search = () => {
  let data = {
    title: form.searchTitle,
    slug: form.searchSlug,
  };
  if (form.searchTitle == "" || form.searchTitle == null) {
    delete data.title;
  }
  if (form.searchSlug == "" || form.searchSlug == null) {
    delete data.slug;
  }

  router.visit("/admin/cms", {
    method: "get",
    data: data,
    replace: false,
  });
};
</script>

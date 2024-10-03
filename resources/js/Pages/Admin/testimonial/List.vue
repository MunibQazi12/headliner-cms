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
                            <Link :href="route('admin.testimonial.create')" class="btn btn-primary"><i
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
                    style="width: 25%"
                    aria-sort="ascending"
                    aria-label="Agent: activate to sort column descending"
                  >
                    Username
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
                    Review
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
                    Rating
                  </th>
                  <th
                    tabindex="0"
                    aria-controls="kt_table_1"
                    rowspan="1"
                    colspan="1"
                    style="width: 25%"
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
                      v-model="form.searchUsername"
                      placeholder=""
                      autocomplete="off"
                      class="form-control-sm form-filter"
                    />
                  </th>
                  <th>
                    <input
                      type="search"
                      v-model="form.searchDescription"
                      placeholder=""
                      autocomplete="off"
                      class="form-control-sm form-filter"
                    />
                  </th>
                  <th>
                    <select
                      class="form-control form-control-sm form-filter kt-input"
                      v-model="form.searchRating"
                    >
                      <option value="">Select Rating</option>
                      <option v-for="n in ratings" :key="n" :value="n">
                        {{ n }}
                      </option>
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
                  v-for="item in testimonials.data"
                  :key="item.id"
                >
                  <td class="sorting_1" tabindex="0">
                    {{ item.username }}
                  </td>
                  <td class="sorting_1" tabindex="0">
                    {{
                      item.description.length > 100
                        ? item.description.substring(0, 100) + ".."
                        : item.description
                    }}
                  </td>
                  <td class="sorting_1" tabindex="0">
                    {{ item.rating }}
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
                          :href="`testimonial/${item.id}/edit`"
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
          <div class="col-sm-12" v-if="testimonials.total == 0">
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
            Showing {{ testimonials.from }} to {{ testimonials.to }} of
            {{ testimonials.total }} entries
          </div>
        </div>
        <div class="col-sm-12 col-md-7">
          <div class="float-right">
            <Bootstrap4Pagination
              :data="testimonials"
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
import { ref, onMounted, onUnmounted } from "vue";
import ListHelper from "../../../helpers/ListHelper";
import perPageDropdown from "@/components/PerpageDropdown.vue";

onMounted(() => {
  emit.emit("pageName", "Resource Management", [
    { title: "All Reviews", routeName: "" },
  ]);
  emit.on("deleteConfirm", function (arg1) {
    deleteConfirm(arg1);
  });
});
const props = defineProps({
  testimonials: Object,
});

onUnmounted(() => {
  emit.off("deleteConfirm");
});

let params = new URLSearchParams(window.location.search);

const deleteRecode = (id) => {
  sw.confirm("deleteConfirm", id);
};

const deleteConfirm = (id) => {
  router.post(route("admin.testimonial.delete", id));
};

const resetSearch = () => {
  router.visit(route("admin.testimonial"), {
    method: "get",
  });
};

const form = useForm({
  searchUsername: params.get("username") || "",
  searchDescription: params.get("description") || "",
  searchRating: params.get("rating") || "",
});
const ratings = ref([1, 2, 3, 4, 5]);

const search = () => {
  let data = {
    username: form.searchUsername,
    description: form.searchDescription,
    rating: form.searchRating,
  };
  if (form.searchUsername == "" || form.searchUsername == null) {
    delete data.username;
  }
  if (form.searchDescription == "" || form.searchDescription == null) {
    delete data.description;
  }
  if (form.searchRating == "" || form.searchRating == null) {
    delete data.rating;
  }

  router.visit(route("admin.testimonial"), {
    method: "get",
    data: data,
    replace: false,
  });
};
</script>

<template lang="">
  <div>
    <Head title="Custom Cut Dry Ice request List" />
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
                                <Link :href="route('admin.product.create')" class="btn btn-primary"><i class="la la-plus"></i>Add New</Link>
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
                      style="width: 20%"
                      aria-sort="ascending"
                      aria-label="Agent: activate to sort column descending"
                    >
                      Full Name
                      <i
                        class="fa fa-fw fa-sort pull-right"
                        style="cursor: pointer"
                        @click="ListHelper.sortBy('full_name')"
                      ></i>
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
                      Email
                      <i
                        class="fa fa-fw fa-sort pull-right"
                        style="cursor: pointer"
                        @click="ListHelper.sortBy('email')"
                      ></i>
                    </th>

                    <th
                      tabindex="0"
                      aria-controls="kt_table_1"
                      rowspan="1"
                      colspan="1"
                      style="width: 15%"
                      aria-label="Company Agent: activate to sort column ascending"
                    >
                      Phone
                    </th>
                    
                    <th
                      tabindex="0"
                      aria-controls="kt_table_1"
                      rowspan="1"
                      colspan="1"
                      style="width: 30%"
                      aria-label="Company Agent: activate to sort column ascending"
                    >
                      Address
                    </th>
                    <th
                      tabindex="0"
                      aria-controls="kt_table_1"
                      rowspan="1"
                      colspan="1"
                      style="width: 30%"
                      aria-label="Company Agent: activate to sort column ascending"
                    >
                      Message
                    </th>
                    
                  </tr>

                  <tr class="filter">
                    <th>
                      <input
                        type="search"
                        v-model="form.searchName"
                        placeholder=""
                        autocomplete="off"
                        class="form-control-sm form-filter"
                      />
                    </th>
                    <th>
                      <input
                        type="search"
                        v-model="form.searchEmail"
                        placeholder=""
                        autocomplete="off"
                        class="form-control-sm form-filter"
                      />
                    </th>
                    <th></th>
                    <th></th>
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
                    v-for="request in props.contact_us.data"
                    :key="request.id"
                  >
                    <td>{{ request.full_name }}</td>
                    <td>
                      {{request.email}}
                    </td>
                    <td>
                      {{request.phone}}
                    </td>
                    <td>
                      {{request.delivery_address}}
                    </td>
                    <td>
                      {{request.message}}
                    </td>
                    
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="col-sm-12" v-if="contact_us.total == 0">
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
              Showing {{ contact_us.from }} to {{ contact_us.to }} of
              {{ contact_us.total }} entries
            </div>
          </div>
          <div class="col-sm-12 col-md-7">
            <div class="float-right">
              <Bootstrap4Pagination
                :data="contact_us"
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
import service from "../../helpers/service";
import ListHelper from "../../helpers/ListHelper";
import perPageDropdown from "@/components/PerpageDropdown.vue";

const props = defineProps({
  contact_us: Object,
  shortBy: String,
});

let params = new URLSearchParams(window.location.search);

const form = useForm({
  searchName: params.get("name") || null,
  searchSlug: params.get("email") || "",
});

onMounted(() => {
  emit.emit("pageName", "Contact Us", [
    {
      title: "Contact Us",
      routeName: "admin.contact-us",
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
  router.visit(route("admin.product.custom-cut-dryice"), {
    method: "get",
  });
};

const search = () => {
  let data = {
    name: form.searchName,
    email: form.searchEmail,
  };
  if (form.searchName == "" || form.searchName == null) {
    delete data.name;
  }
  if (form.searchEmail == "" || form.searchEmail == null) {
    delete data.email;
  }
 

  router.visit(route("admin.contact-us"), {
    method: "get",
    data: data,
    replace: false,
  });
};

const deleteRecode = (id) => {
  sw.confirm("deleteConfirm", id);
};

const deleteConfirm = (id) => {
  router.delete(route("admin.productDelete", id));
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

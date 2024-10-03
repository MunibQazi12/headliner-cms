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
                    style="width: 20%"
                    aria-sort="ascending"
                    aria-label="Agent: activate to sort column descending"
                  >
                    Customer Name
                  </th>
                  <th
                    tabindex="0"
                    aria-controls="kt_table_1"
                    rowspan="1"
                    colspan="1"
                    style="width: 10%"
                    aria-sort="ascending"
                    aria-label="Agent: activate to sort column descending"
                  >
                    Email
                  </th>
                  <th
                    tabindex="0"
                    aria-controls="kt_table_1"
                    rowspan="1"
                    colspan="1"
                    style="width: 10%"
                    aria-sort="ascending"
                    aria-label="Agent: activate to sort column descending"
                  >
                    Order Amount
                  </th>
                  <th
                    tabindex="0"
                    aria-controls="kt_table_1"
                    rowspan="1"
                    colspan="1"
                    style="width: 10%"
                    aria-sort="ascending"
                    aria-label="Agent: activate to sort column descending"
                  >
                    Shipping Charge
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
                    Date
                  </th>
                    <th
                    tabindex="0"
                    aria-controls="kt_table_1"
                    rowspan="1"
                    colspan="1"
                    style="width: 10%"
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
                    style="width: 40%"
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
                   
                  </th>
                  <th>
                    
                  </th>
                  <th>
                    
                  </th>
                  <th>
                    
                  </th>
                  <th>
                    
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
                  v-for="item in orders.data"
                  :key="item.id"
                >
                  <td>
                     <Link :href="route('admin.viewOrder', item.id)">{{ item.user.first_name }}</Link>
                  </td>
                     <td>
                    {{ item.user.email }}
                   
                  </td>
                  <td>
                    {{ item.amount }}
                   
                  </td>

                  <td>
                    {{ item.shipping_charge}}
                  </td>
                  <td>
                    {{ new Date(item.created_at).toDateString()}}
                  </td>
                   <td>
                    <span
                      @click="changeStatus(item.id)"
                      style="cursor: pointer"
                      class="kt-badge kt-badge--inline kt-badge--pill cursor-pointer"
                      :class="getBadgeClass(item.status)"
                      >{{ item.status}}</span
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
                           :href="route('admin.viewOrder', item.id)">
                           <i class="la la-eye"></i>
                           View</Link>
                      </div>
                    </span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="col-sm-12" v-if="orders.total == 0">
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
              Showing {{ orders.from }} to {{ orders.to }} of
              {{ orders.total }} entries
            </div>
          </div>
          <div class="col-sm-12 col-md-7">
            <div class="float-right">
              <Bootstrap4Pagination
                :data="orders"
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
  orders: Object,
});

let params = new URLSearchParams(window.location.search);

const form = useForm({
  searchTitle: params.get("name") || null,
});
      function getBadgeClass(status) {
      // Return the appropriate class based on the status
      switch (status) {
        case 'new':
          return 'kt-badge--dark';
        case 'processing':
          return 'kt-badge--info'; // Assuming you want a different color for 'processing'
        case 'shipped':
          return 'kt-badge--primary'; // Assuming you want a different color for 'shipped'
        case 'delivered':
          return 'kt-badge--success'; // Use the same color or different if needed
        case 'cancelled':
          return 'kt-badge--danger';
        default:
          return 'kt-badge--warning'; // Default color if status is unknown
      }
    }
const changeStatus = (id) => {
  const statuses = ["new" , "processing" , "shipped" , "delivered" , "cancelled"];
   Swal.fire({
    title: 'Select Status',
    input: 'select',
    inputOptions: {
      'statuses': statuses.reduce((options, status) => {
        options[status] = status;
        return options;
      }, {})
    },
    inputPlaceholder: 'Select a status',
    showCancelButton: true,
    confirmButtonText: 'Submit',
    cancelButtonText: 'Cancel',
    inputValidator: (value) => {
      if (!value) {
        return 'You need to select a status!';
      }
    }
  }).then((result) => {
    if (result.isConfirmed) {
      const selectedStatus = result.value;
      changeStatusConfirm(id, selectedStatus);
    }
  });
};

const changeStatusConfirm = (id , selectedStatus) => {
  let data = {
    id: id,
    status : selectedStatus
  };
  router.post(route("admin.order.status"), data);
};

onMounted(() => {
  emit.emit("pageName", "Order Management", [
    {
      title: "All Order",
      routeName: "admin.orders",
    },
  ]);

});





const resetSearch = () => {
  router.visit(route("admin.orders"), {
    method: "get",
  });
};

const search = () => {
  let data = {
    name: form.searchTitle,
  };

  if (form.searchTitle == "" || form.searchTitle == null) {
    delete data.name;
  }
  

  router.visit(route("admin.orders"), {
    method: "get",
    data: data,
    replace: false,
  });
};
</script>

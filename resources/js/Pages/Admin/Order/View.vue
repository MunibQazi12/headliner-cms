<template>
  <div class="kt-portlet kt-portlet--mobile">
    
    <div class="kt-portlet__body">
      <div class="row">
        <div class="col-md-4 ">
          <h5>Customer Name: {{order.user.first_name}} {{order.user.last_name}}</h5> 
        </div>
        <div class="col-md-4 ">
          <h5>Customer Email: {{order.user.email}} </h5> 
        </div>
        <div class="col-md-4 ">
          <h5>Order Amount: ${{order.amount}} </h5> 
        </div>
        <div class="col-md-4 ">
          <h5>Shipping Fee: ${{order.shipping_charge}} </h5> 
        </div>
        <div class="col-md-4 ">
          <h5>Date: {{new Date(order.created_at).toDateString()}} </h5> 
        </div>
      </div>
      <div
        id="kt_table_1_wrapper"
        class="dataTables_wrapper dt-bootstrap4 no-footer"
      >
       

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
                    Product
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
                    Size
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
                    Quantity
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
                    Price
                  </th>

                  
                </tr>
                
              </thead>
               
              <tbody v-auto-animate>
                <tr
                  role="row"
                  class="odd"
                  v-for="item in order.order_item"
                  :key="item.id"
                >
              
                  <td>
                     {{ item.product.name }}
                  </td>
                  <td>
                    {{ item.product_attribute.size }}
                   
                  </td>

                  <td>
                    {{ item.quantity}}
                  </td>
                  <td>
                    {{ item.price}}
                  </td>

                  
                </tr>
              </tbody>
            </table>
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
  order: Object,
});

let params = new URLSearchParams(window.location.search);

const form = useForm({
  searchTitle: params.get("name") || null,
});

onMounted(() => {
  emit.emit("pageName", "Order Management", [
    {
      title: "All Order",
      routeName: "admin.orders",
    },
  ]);

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


const resetSearch = () => {
  router.visit(route("admin.orders"), {
    method: "get",
  });
};


</script>

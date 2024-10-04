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
            <div class="col-sm-12 col-md-6 d-flex align-items-center gap-3">
              <perPageDropdown />
              <div class="mb-2 ml-4">
                <div class="dropdown">
                  <div
                    class="btn border border-secondary dropdown-toggle"
                    type="button"
                    data-toggle="dropdown"
                    aria-expanded="false"
                  >
                    Locations
                  </div>
                  <div
                    class="dropdown-menu p-3"
                    @click.stop
                    :style="{ width: '800px' }"
                  >
                    <div class="row">
                      <div
                        v-for="item in geoMap"
                        :key="item.value"
                        class="d-flex align-items-center py-2 col-3"
                      >
                        <input
                          type="checkbox"
                          :id="`checkbox-${item.value}`"
                          :v-model="`checkbox-${item.value}`"
                          :name="`checkbox-${item.value}`"
                          :checked="locations.includes(item.value)"
                          @change="onChangeLocation(item.value)"
                          :value="item.value"
                        />
                        <a
                          @click="onChangeLocation(item.value)"
                          class="ml-2 kmenuLinkText"
                        >
                          {{ item.label }}
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="mb-2 ml-4">
                <div class="dropdown">
                  <div
                    class="btn border border-secondary dropdown-toggle"
                    type="button"
                    data-toggle="dropdown"
                    aria-expanded="false"
                  >
                    Distance
                  </div>
                  <div
                    class="dropdown-menu p-3 mt-2"
                    @click.stop
                    :style="{ width: '200px' }"
                  >
                    <div class="">
                      <div
                        v-for="item in Distance"
                        :key="item.value"
                        class="d-flex-col d-flex align-items-center py-2 customInputCheckBox"
                      >
                        <input
                          :style="{ height: '16px' , width : '16px' }"
                          type="checkbox"
                          :id="`checkbox-${item.value}`"
                          :v-model="`checkbox-${item.value}`"
                          :name="`checkbox-${item.value}`"
                          :checked="distance === item.value"
                          @change="onChangeDistance(item.value)"
                          :value="item.value"
                        />
                        <a
                          @click="onChangeDistance(item.value)"
                          class="ml-2 kmenuLinkText"
                        >
                          {{ item.label }}
                        </a>
                      </div>
                      <div   
                      :style="{ marginTop: '10px' , marginBottom : '20px' }">
                        Custom Distance
                        <input
                        type="text"
                        v-model="customDistance"
                        class="form-control"
                      />
                    </div>
                    <div class="d-flex justify-content-between">
                    <button
                      class="btn btn-brand kt-btn btn-sm cmnBtn "
                      @click="onChangeDistance(customDistance)"
                      :style="{ width:'45%' }"
                    >
                      Save
                    </button>
                    <button
                      class="btn btn-brand kt-btn btn-sm cmnBtnTw"
                      :disabled="!customDistance"
                     @click="onChangeDistance('')"
                     :style="{ width:'45%' }"
                    >
                      Reset
                    </button> 
                  </div>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="mb-2 ml-4">
                <div class="dropdown">
                  <div
                    class="btn border border-secondary dropdown-toggle"
                    type="button"
                    data-toggle="dropdown"
                    aria-expanded="false"
                      :style="{ width: '120px' }"
                  >
                    {{actions? actions : 'Actions'}}
                  </div>
                  <div
                    class="dropdown-menu p-3 mt-2"
                    :style="{ width: '120px' }"
                  >
                  
                      <div class="d-flex flex-column gap-2">
                      <button
                            class="btn btn-brand kt-btn btn-sm kt-btn--icon button-fx cmnBtn "
                             @click="onChangeActions('Publish')"
                          >
                            <span>
                       
                              <span>Publish</span>
                            </span>
                          </button>
                          <button
                            class="btn btn-brand kt-btn btn-sm kt-btn--icon button-fx cmnBtnTw mt-2"
                             @click="onChangeActions('Unpublish')"
                          >
                            <span>
                    
                              <span>Unpublish</span>
                            </span>
                          </button>
                        </div>
                    
                  </div>
                </div>
              </div>
              <div class="mb-2 ml-4">
              <button
                            class="btn btn-brand kt-btn btn-sm kt-btn--icon button-fx cmnBtn"
                            :disabled="seoIds.length === 0 || !actions"
                            @click="onApplyClick()"
                          >
                            <span>
                              <span>Apply</span>
                            </span>
                          </button></div>
            </div>
            <!-- <div class="col-sm-12 col-md-6">
                <div id="kt_table_1_filter" class="dataTables_filter">
                    <Link :href="route('admin.resource-create')" class="btn btn-primary"><i class="la la-plus"></i>Add New</Link>
                </div>
            </div> -->
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
                    <th></th>
                    <th
                      tabindex="0"
                      aria-controls="kt_table_1"
                      rowspan="1"
                      colspan="1"
                      style="width: 30%"
                      aria-sort="ascending"
                      aria-label="Agent: activate to sort column descending"
                      :style="{fontSize : '15px' , fontWeight:'600' }"
                    >
                      Page name
                      <i
                        class="fa fa-fw fa-sort pull-right"
                        style="cursor: pointer"
                        @click="ListHelper.sortBy('meta_title')"
                      ></i>
                    </th>
                    <th
                      tabindex="0"
                      aria-controls="kt_table_1"
                      rowspan="1"
                      colspan="1"
                      style="width: 30%"
                      aria-sort="ascending"
                      aria-label="Agent: activate to sort column descending"
                      :style="{fontSize : '15px' , fontWeight:'600' }"
                    >
                      Status
                      <i
                        class="fa fa-fw fa-sort pull-right"
                        style="cursor: pointer"
                        @click="ListHelper.sortBy('Status')"
                      ></i>
                    </th>
                    <th
                      class="align-center"
                      rowspan="1"
                      colspan="1"
                      style="width: 15%"
                      aria-label="Actions"
                      :style="{fontSize : '15px' , fontWeight:'600' }"
                    >
                      Actions
                    </th>
                  </tr>

                  <tr class="filter">
                    <th :style="{ width: '5%' , textAlign:'center' , verticalAlign:'middle' }">
                      <input
                          type="checkbox"
                          :id="`SEO`"
                          :checked=" props?.seopages.data.length &&  seoIds.length === props?.seopages?.data.length"
                          @change="onChangeTableSelect()"
                        />
                    </th>
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
                            <span class='d-flex'>
                              <i :style="{ position : 'relative' , top : '9px'}" class="la la-search"></i>
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
                    v-for="seo in props?.seopages?.data"
                    :key="seo.id"
                  >
                  <td :style="{ width: '5%' , textAlign:'center' , verticalAlign:'middle' }">
                    <input
                          type="checkbox"
                          :id="`${seo.id}`"
                          :name="`checkbox-${seo.id}`"
                          :checked="seoIds.includes(seo.id)"
                          @change="onChangeSeoSelect(seo.id)"
                        />
                  </td>
                  <td :style="{fontSize : '15px' , fontWeight:'400' }">
                      
                      {{ seo.meta_title }}
               
                  </td>
                  <td class="align-center">
                      <span
                        @click="changeStatus(seo.id)"
                        style="cursor: pointer"
                        class="kt-badge kt-badge--inline kt-badge--pill cursor-pointer"
                        :class="
                          seo.status == 1
                            ? 'kt-badge--success'
                            : 'kt-badge--warning'
                        "
                        >{{ seo.status == 1 ? "Live" : "Inactive" }}</span
                      >
                    </td>
                    <td nowrap="" class="align-center">
                      <span class="dropdown">
                        <a
                          href="#"
                          class="btn btn-brand kt-btn btn-sm kt-btn--icon button-fx cmnBtnTw"
                          data-toggle="dropdown"
                          :style="{ backgroundColor: '#7CB9E8 !important' , border:'none' }"
                        >
                           <button
                            href="#"
                            class="dropdown-item"
                          :style="{ color: '#fff !important' , fontWeight : '500'  }"

                          >
                            Edit
                          </button>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                          <Link
                            class="dropdown-item"
                            :href="route('admin.seo.page.edit', seo.slug)"
                            ><i class="la la-edit"></i> Edit</Link
                          >
                          <button
                            href="#"
                            class="dropdown-item"
                            @click="deleteRecode(seo.id)"
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
            <div class="col-sm-12" v-if="props?.seopages?.data.length == 0">
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
              Showing {{ props?.seopages?.from }} to
              {{ props?.seopages?.to }} of {{ props?.seopages?.total }} entries
            </div>
          </div>
          <div class="col-sm-12 col-md-7">
            <div class="float-right">
              <Bootstrap4Pagination
                :data="seopages"
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
  seopages: Object,
  locationsSelected: Array | null,
  distanceSelected: Array | null,
});

const customDistance = ref("");
let seoIds = ref([]);

let locations = props.locationsSelected ? props.locationsSelected : [];
let distance = props.distanceSelected ? props.distanceSelected : '';

const actions = ref('')

const geoMap = [
  { label: "Alabama", value: "alabama", longitude: -86.902298, latitude: 32.318231 },
  { label: "Alaska", value: "alaska", longitude: -149.493673, latitude: 64.200841 },
  { label: "Arizona", value: "arizona", longitude: -111.093731, latitude: 34.048928 },
  { label: "Arkansas", value: "arkansas", longitude: -92.373123, latitude: 35.20105 },
  { label: "California", value: "california", longitude: -119.417931, latitude: 36.778259 },
  { label: "Colorado", value: "colorado", longitude: -105.782067, latitude: 39.550051 },
  { label: "Connecticut", value: "connecticut", longitude: -72.694783, latitude: 41.603221 },
  { label: "Delaware", value: "delaware", longitude: -75.52767, latitude: 38.910832 },
  { label: "Florida", value: "florida", longitude: -81.760254, latitude: 27.994402 },
  { label: "Georgia", value: "georgia", longitude: -82.900075, latitude: 32.165622 },
  { label: "Hawaii", value: "hawaii", longitude: -155.582782, latitude: 19.896766 },
  { label: "Idaho", value: "idaho", longitude: -114.742041, latitude: 44.068202 },
  { label: "Illinois", value: "illinois", longitude: -89.398528, latitude: 40.633125 },
  { label: "Indiana", value: "indiana", longitude: -86.134902, latitude: 40.267194 },
  { label: "Iowa", value: "iowa", longitude: -93.097702, latitude: 41.878003 },
  { label: "Kansas", value: "kansas", longitude: -98.484246, latitude: 39.011902 },
  { label: "Kentucky", value: "kentucky", longitude: -84.270018, latitude: 37.839333 },
  { label: "Louisiana", value: "louisiana", longitude: -91.962333, latitude: 30.984298 },
  { label: "Maine", value: "maine", longitude: -69.445469, latitude: 45.253783 },
  { label: "Maryland", value: "maryland", longitude: -76.641271, latitude: 39.045755 },
  { label: "Massachusetts", value: "massachusetts", longitude: -71.382437, latitude: 42.407211 },
  { label: "Michigan", value: "michigan", longitude: -85.602364, latitude: 44.314844 },
  { label: "Minnesota", value: "minnesota", longitude: -94.6859, latitude: 46.729553 },
  { label: "Missouri", value: "missouri", longitude: -92.288368, latitude: 37.964253 },
  { label: "Montana", value: "montana", longitude: -110.362566, latitude: 46.879682 },
  { label: "Nebraska", value: "nebraska", longitude: -99.901813, latitude: 41.492537 },
  { label: "Nevada", value: "nevada", longitude: -116.419389, latitude: 38.80261 },
  { label: "New Hampshire", value: "new-hampshire", longitude: -71.572395, latitude: 43.193852 },
  { label: "New Jersey", value: "new-jersey", longitude: -74.405661, latitude: 40.058324 },
  { label: "New York", value: "new-york", longitude: -74.005941, latitude: 40.712776 },
  { label: "North Carolina", value: "north-carolina", longitude: -79.0193, latitude: 35.759573 },
  { label: "North Dakota", value: "north-dakota", longitude: -101.002012, latitude: 47.551493 },
  { label: "Ohio", value: "ohio", longitude: -82.907123, latitude: 40.417287 },
  { label: "Oklahoma", value: "oklahoma", longitude: -97.516428, latitude: 35.007752 },
  { label: "Oregon", value: "oregon", longitude: -120.554201, latitude: 43.804133 },
  { label: "Pennsylvania", value: "pennsylvania", longitude: -77.194525, latitude: 41.203322 },
  { label: "Rhode Island", value: "rhode-island", longitude: -71.477429, latitude: 41.580095 },
  { label: "South Carolina", value: "south-carolina", longitude: -81.163725, latitude: 33.836081 },
  { label: "South Dakota", value: "south-dakota", longitude: -99.901813, latitude: 43.969515 },
  { label: "Tennessee", value: "tennessee", longitude: -86.580447, latitude: 35.517491 },
  { label: "Texas", value: "texas", longitude: -99.901813, latitude: 31.968599 },
  { label: "Utah", value: "utah", longitude: -111.093731, latitude: 39.32098 },
  { label: "Vermont", value: "vermont", longitude: -72.5778, latitude: 44.5588 },
  { label: "Virginia", value: "virginia", longitude: -78.6569, latitude: 37.4316 },
  { label: "West Virginia", value: "west-virginia", longitude: -80.4549, latitude: 38.5976 },
  { label: "Wisconsin", value: "wisconsin", longitude: -89.6165, latitude: 43.7844 },
  { label: "Wyoming", value: "wyoming", longitude: -107.2903, latitude: 43.07597 }
];

const Distance = [
  { label: "50 Miles", value: "50" },
  { label: "100 Miles", value: "100" },
  { label: "150 Miles", value: "150" },
  { label: "200 Miles", value: "200" },
  { label: "250 Miles", value: "250" },
  { label: "300 Miles", value: "300" },
];

customDistance.value = Distance.some((dis) => dis.value === distance) ? '' : distance;



let params = new URLSearchParams(window.location.search);
onMounted(() => {
  emit.emit("pageName", "Seo Settings Management", [
    {
      title: "Seo Pages List",
      routeName: "admin.seo.pages",
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
  router.visit(route("admin.seo.pages"), {
    method: "get",
  });
};

const form = useForm({
  searchName: params.get("page") || "",
});

function arrayToSearchParams(key, array) {
  let params = "";
  array.forEach((value) => {
    params += `${key}[]` + value;
  });

  return params;
}

// const onChangeLocation = (newLocation) => {
//   locations = locations.includes(newLocation)
//     ? locations.filter((item) => item !== newLocation)
//     : [...locations, newLocation];

//   router.visit(route("admin.seo.pages"), {
//     method: "get",
//     data: {
//       locations :  locations
//     },
//     replace: true,
//   });
// };

// const onChangeDistance = (newDistance) => {
//   if(newDistance && distance === newDistance) {
//     router.visit(route("admin.seo.pages"), {
//     method: "get",
//     replace: true,
//    });
//    return;
//   }
//    distance = newDistance
//   if (!newDistance) {
//     customDistance.value = newDistance; 
//     return;
//   }

//   router.visit(route("admin.seo.pages"), {
//     method: "get",
//     data: {
//       distance :  distance
//     },
//     replace: true,
//   });
// };

const onChangeLocation = (newLocation) => {
  locations = locations.includes(newLocation)
    ? locations.filter((item) => item !== newLocation)
    : [...locations, newLocation];

  sendRequest();
};

const onChangeDistance = (newDistance) => {
  if (newDistance && distance === newDistance) {
    distance = '';
  } else {
    distance = newDistance;

  }
  sendRequest();
};

const sendRequest = () => {
  const requestData = {};

  if (locations && locations.length > 0) {
    const filteredCoordinates = geoMap
      .filter(location => locations.includes(location.value))
      .map(location => location.value + "|" + location.longitude + '|' + location.latitude);

    requestData.locations = locations;
    requestData.filteredCoordinates = filteredCoordinates;
  }

  if (distance !== null && distance !== undefined) {
    requestData.distance = distance;
  }

  if (Object.keys(requestData).length > 0) {
    router.visit(route("admin.seo.pages"), {
      method: "get",
      data: requestData,
      replace: true,
    });
  }
};

const onChangeActions = (newAction) => {
  actions.value = newAction
};

const onChangeSeoSelect = (id) => {
  if (seoIds.value.includes(id)) {
    seoIds.value = seoIds.value.filter((item) => item !== id);
  } else {
    seoIds.value.push(id);
  }
};
const onChangeTableSelect = () => {
  if (seoIds.value.length === props?.seopages?.data.length) {
    seoIds.value = []
  } else {
    seoIds.value = props?.seopages?.data.map(seo => seo.id);
  }
}

const onApplyClick = () => {
  if (seoIds.value.length === 0) return; // Do nothing if no SEO IDs are selected

  const data = {
    id: seoIds.value.join(','), // Send comma-separated values
    action: actions.value,
  };

  router.post(route("admin.changeSeoStatus"), data);
  seoIds.value = []; // Reset the state after submission
  actions.value = ''
};

const search = () => {
  let data = {
    name: form.searchName,
  };
  if (form.searchName == "" || form.searchName == null) {
    delete data.name;
  }

  router.visit(route("admin.seo.pages"), {
    method: "get",
    data: data,
    replace: false,
  });
};
const changeStatusConfirm = (id) => {
  let data = {
    id: id,
  };
  router.post(route("admin.changeSeoStatus"), data);
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

const deleteRecode = (id) => {
  sw.confirm("deleteConfirm", id);
};

const deleteConfirm = (id) => {
  router.delete(route("admin.deleteSeo", id));
};
</script>
<style lang=""></style>

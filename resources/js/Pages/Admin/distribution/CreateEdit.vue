<template lang="">
  <div>
    <Head title="Create Dealer" v-if="!props.user" />
    <Head title="Edit Dealer" v-if="props.user" />
    <div class="kt-portlet kt-portlet--mobile">
      <div class="kt-portlet__body">
        <form @submit.prevent="submit">
          <div class="form-group validated row" v-auto-animate>
            <div class="form-group col-lg-6">
              <label for="center_name"
                >Center Name <span class="text-danger">*</span></label
              >
              <input
                type="text"
                id="center_name"
                v-model="form.center_name"
                class="form-control border-gray-200"
                placeholder="Center Name"
              />
              <span class="text-danger" v-if="form.errors.center_name">{{
                form.errors.center_name
              }}</span>
            </div>

            <div class="form-group col-lg-6">
              <label for="title"
                >Address <span class="text-danger">*</span></label
              >
              <input
                type="text"
                id="address"
                v-model="form.address_line_1"
                class="form-control border-gray-200"
                placeholder="Address"
              />
              <!-- <vue-google-autocomplete
                ref="addressRef"
                country="us"
                id="map"
                classname="form-control"
                placeholder="Address"
                v-on:placechanged="getAddressData"
              >
              </vue-google-autocomplete> -->
              <span class="text-danger" v-if="form.errors.address_line_1">{{
                form.errors.address_line_1
              }}</span>
            </div>

            <!-- 
            <div class="form-group col-lg-6">
              <label for="city">City <span class="text-danger">*</span></label>
              <input
                type="text"
                id="city"
                v-model="form.city"
                class="form-control border-gray-200"
                placeholder="Center Name"
              />
              <span class="text-danger" v-if="form.errors.city">{{
                form.errors.city
              }}</span>
            </div>

            <div class="form-group col-lg-6">
              <label for="state">State<span class="text-danger">*</span></label>
              <input
                type="text"
                id="state"
                v-model="form.state"
                class="form-control border-gray-200"
                placeholder="Center Name"
              />
              <span class="text-danger" v-if="form.errors.state">{{
                form.errors.state
              }}</span>
            </div>

            <div class="form-group col-lg-6">
              <label for="zip_code"
                >Zip Code<span class="text-danger">*</span></label
              >
              <input
                type="number"
                id="zip_code"
                v-model="form.zip_code"
                class="form-control border-gray-200"
                placeholder="Zip Code"
              />
              <span class="text-danger" v-if="form.errors.zip_code">{{
                form.errors.zip_code
              }}</span>
            </div> -->

            <div class="form-group col-lg-6">
              <label for="latitude"
                >Latitude<span class="text-danger">*</span></label
              >
              <input
                type="text"
                id="latitude"
                @input="validateLatitude"
                v-model="form.latitude"
                class="form-control border-gray-200"
                placeholder="Latitude"
              />
              <span class="text-danger" v-if="form.errors.latitude">{{
                form.errors.latitude
              }}</span>
            </div>

            <div class="form-group col-lg-6">
              <label for="longitude"
                >Longitude<span class="text-danger">*</span></label
              >
              <input
                type="text"
                id="longitude"
                @input="validateLatitude"
                v-model="form.longitude"
                class="form-control border-gray-200"
                placeholder="Longitude"
              />
              <span class="text-danger" v-if="form.errors.longitude">{{
                form.errors.longitude
              }}</span>
            </div>

            <div class="form-group col-lg-6">
              <label for="status"
                >Status <span class="text-danger">*</span></label
              >
              <select
                id="status"
                class="form-control border-gray-200"
                v-model="form.status"
              >
                <option value="">Select Status</option>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
              </select>
              <span class="text-danger" v-if="form.errors.status">{{
                form.errors.status
              }}</span>
            </div>
          </div>
          <div class="kt-portlet__foot">
            <div class="kt-form__actions">
              <div class="row">
                <div class="pr-2">
                  <submit-button
                    :disabled="form.processing"
                    :isLoading="form.processing"
                    >Submit</submit-button
                  >
                </div>
                <div>
                  <Link
                    :href="route('admin.distribution.center')"
                    class="btn btn-secondary"
                    >Cancel</Link
                  >
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
<script>
import VueGoogleAutocomplete from "vue-google-autocomplete";

export default {
  components: { VueGoogleAutocomplete },

  data: function () {
    return {
      address: "",
    };
  },
};
</script>
<script setup>
import { onMounted, ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import SubmitButton from "../../../components/SubmitButton.vue";
import VueGoogleAutocomplete from "vue-google-autocomplete";

const props = defineProps({
  errors: Object,
  distribution: Object,
});

const form = useForm({
  address_line_1: props.distribution?.address_line_1 || null,
  center_name: props.distribution?.center_name || null,
  status: props.distribution?.status || "",
  latitude: props.distribution?.latitude || null,
  longitude: props.distribution?.longitude || null,
});

// const addressRef = ref(null);

// const getAddressData = (addressData, placeResultData, id) => {
//   form.address_line_1 = placeResultData.formatted_address;
//   form.latitude = addressData.latitude;
//   form.longitude = addressData.longitude;
// };
const validateLatitude = (event) => {
  const value = event.target.value;
  // Regular expression to match a valid latitude input
  const regex = /^-?\d*\.?\d*$/;

  if (!regex.test(value)) {
    // If the input is invalid, reset the value to the last valid input
    event.target.value = this.form.latitude;
  } else {
    // Otherwise, update the model with the valid input
    this.form.latitude = value;
  }
};

onMounted(() => {
  if (props.distribution) {
    emit.emit("pageName", "Resource Management", [
      {
        title: "Distribution Center List",
        routeName: "admin.distribution-center",
      },
      {
        title: "Edit Distribution Center",
        routeName: "",
      },
    ]);
  } else {
    emit.emit("pageName", "Resource Management", [
      {
        title: "Distribution Center List",
        routeName: "admin.distribution-center",
      },
      {
        title: "Add Distribution Center",
        routeName: "",
      },
    ]);
  }
});

function submit() {
  if (props.distribution) {
    form.post(route("admin.distribution.edit", props.distribution.id));
  } else {
    form.post(route("admin.distribution.create"));
  }
}
</script>

<style lang=""></style>

<template>
  <div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__body">
      <form @submit.prevent="submit">
        <div class="form-group validated row">
          <div class="form-group col-lg-6">
            <label for="slug">Slug <span class="text-danger">*</span></label>
            <input
              type="text"
              id="slug"
              v-model="form.slug"
              class="form-control border-gray-200"
              placeholder="Slug"
            />
            <span class="text-danger" v-if="form.errors.slug">{{
              form.errors.slug
            }}</span>
          </div>
          <div class="form-group col-lg-6">
            <label>Meta Title </label>
            <input
              type="text"
              id="title"
              v-model="form.meta_title"
              class="form-control border-gray-200"
              placeholder="Enter Meta Title"
            />
            <span class="text-danger" v-if="form.errors.meta_title">{{
              form.errors.meta_title
            }}</span>
          </div>
          <div class="form-group col-lg-6">
            <label for="category_id">Meta Description </label>
            <textarea
              name=""
              id=""
              class="form-control border-gray-200"
              v-model="form.meta_description"
              placeholder="Enter Meta Description"
              rows="5"
            ></textarea>
            <span class="text-danger" v-if="form.errors.meta_description">{{
              form.errors.meta_description
            }}</span>
          </div>
          <div class="form-group col-lg-6">
            <label>H1 Tag </label>
            <input
              type="text"
              id=""
              v-model="form.h1_tag"
              class="form-control border-gray-200"
              placeholder="Heading"
            />
            <span class="text-danger" v-if="form.errors.h1_tag">{{
              form.errors.h1_tag
            }}</span>
          </div>
          <div class="form-group col-lg-6">
            <label>City in Lowercase </label>
            <input
              type="text"
              id="title"
              v-model="form.city_lowercase"
              class="form-control border-gray-200"
              placeholder="Enter Open Graph Title"
            />
            <span class="text-danger" v-if="form.errors.city_lowercase">{{
              form.errors.city_lowercase
            }}</span>
          </div>
          <div class="form-group col-lg-6">
            <label>State Short Abbr. </label>
            <input
              type="text"
              id="title"
              v-model="form.state_short_abbr"
              class="form-control border-gray-200"
              placeholder="Enter Open Graph Title"
            />
            <span class="text-danger" v-if="form.errors.state_short_abbr">{{
              form.errors.state_short_abbr
            }}</span>
          </div>
          <div class="form-group col-lg-6">
            <label>City </label>
            <input
              type="text"
              id="title"
              v-model="form.city"
              class="form-control border-gray-200"
              placeholder="Enter Open Graph Title"
            />
            <span class="text-danger" v-if="form.errors.city">{{
              form.errors.city
            }}</span>
          </div>
          <div class="form-group col-lg-6">
            <label>State Code</label>
            <input
              type="text"
              id="title"
              v-model="form.state_code"
              class="form-control border-gray-200"
              placeholder="Enter Open Graph Title"
            />
            <span class="text-danger" v-if="form.errors.state_code">{{
              form.errors.state_code
            }}</span>
          </div>
          <div class="form-group col-lg-6">
            <label>State</label>
            <input
              type="text"
              id="title"
              v-model="form.state"
              class="form-control border-gray-200"
              placeholder="Enter Open Graph Title"
            />
            <span class="text-danger" v-if="form.errors.state">{{
              form.errors.state
            }}</span>
          </div>
          <div class="form-group col-lg-6">
            <label>Zip Code</label>
            <input
              type="text"
              id="title"
              v-model="form.zip_codes"
              class="form-control border-gray-200"
              placeholder="Enter Open Graph Title"
            />
            <span class="text-danger" v-if="form.errors.zip_codes">{{
              form.errors.zip_codes
            }}</span>
          </div>
          <div class="form-group col-lg-6">
            <label>Type</label>
            <input
              type="text"
              id="title"
              v-model="form.type"
              class="form-control border-gray-200"
              placeholder="Enter Open Graph Title"
            />
            <span class="text-danger" v-if="form.errors.type">{{
              form.errors.type
            }}</span>
          </div>
          <div class="form-group col-lg-6">
            <label>Latitude</label>
            <input
              type="text"
              id="title"
              v-model="form.latitude"
              class="form-control border-gray-200"
              placeholder="Enter Open Graph Title"
            />
            <span class="text-danger" v-if="form.errors.latitude">{{
              form.errors.latitude
            }}</span>
          </div>
          <div class="form-group col-lg-6">
            <label>Longitude</label>
            <input
              type="text"
              id="title"
              v-model="form.longitude"
              class="form-control border-gray-200"
              placeholder="Enter Open Graph Title"
            />
            <span class="text-danger" v-if="form.errors.longitude">{{
              form.errors.longitude
            }}</span>
          </div>

          <div class="form-group col-lg-6">
            <label for="category_id">FAQ Qus 1 </label>
            <textarea
              name=""
              id=""
              class="form-control border-gray-200"
              placeholder="Question"
              rows="5"
              v-model="form.faq_q_1"
            ></textarea>
            <span class="text-danger" v-if="form.errors.faq_q_1">{{
              form.errors.faq_q_1
            }}</span>
          </div>
          <div class="form-group col-lg-6">
            <label for="category_id">FAQ Ans 1 </label>
            <textarea
              name=""
              id=""
              class="form-control border-gray-200"
              placeholder="Answer"
              rows="5"
              v-model="form.faq_a_1"
            ></textarea>
            <span class="text-danger" v-if="form.errors.faq_a_1">{{
              form.errors.faq_a_1
            }}</span>
          </div>
          <div class="form-group col-lg-6">
            <label for="category_id">FAQ Qus 2 </label>
            <textarea
              name=""
              id=""
              class="form-control border-gray-200"
              placeholder="Question"
              rows="5"
              v-model="form.faq_q_2"
            ></textarea>
            <span class="text-danger" v-if="form.errors.faq_q_2">{{
              form.errors.faq_q_2
            }}</span>
          </div>
          <div class="form-group col-lg-6">
            <label for="category_id">FAQ Ans 2 </label>
            <textarea
              name=""
              id=""
              class="form-control border-gray-200"
              placeholder="Answer"
              rows="5"
              v-model="form.faq_a_2"
            ></textarea>
            <span class="text-danger" v-if="form.errors.faq_a_2">{{
              form.errors.faq_a_2
            }}</span>
          </div>

          <div class="form-group col-lg-6">
            <label for="category_id">FAQ Qus 3 </label>
            <textarea
              name=""
              id=""
              class="form-control border-gray-200"
              placeholder="Question"
              rows="5"
              v-model="form.faq_q_3"
            ></textarea>
            <span class="text-danger" v-if="form.errors.faq_q_3">{{
              form.errors.faq_q_3
            }}</span>
          </div>
          <div class="form-group col-lg-6">
            <label for="category_id">FAQ Ans 3 </label>
            <textarea
              name=""
              id=""
              class="form-control border-gray-200"
              placeholder="Answer"
              rows="5"
              v-model="form.faq_a_3"
            ></textarea>
            <span class="text-danger" v-if="form.errors.faq_a_3">{{
              form.errors.faq_a_3
            }}</span>
          </div>
          <div class="form-group col-lg-6">
            <label for="category_id">FAQ Qus 4 </label>
            <textarea
              name=""
              id=""
              class="form-control border-gray-200"
              placeholder="Question"
              rows="5"
              v-model="form.faq_q_4"
            ></textarea>
            <span class="text-danger" v-if="form.errors.faq_q_4">{{
              form.errors.faq_q_4
            }}</span>
          </div>
          <div class="form-group col-lg-6">
            <label for="category_id">FAQ Ans 4 </label>
            <textarea
              name=""
              id=""
              class="form-control border-gray-200"
              placeholder="Answer"
              rows="5"
              v-model="form.faq_a_4"
            ></textarea>
            <span class="text-danger" v-if="form.errors.faq_a_4">{{
              form.errors.faq_a_4
            }}</span>
          </div>

          <div class="form-group col-lg-6">
            <label for="category_id">FAQ Qus 5 </label>
            <textarea
              name=""
              id=""
              class="form-control border-gray-200"
              placeholder="Question"
              rows="5"
              v-model="form.faq_q_5"
            ></textarea>
            <span class="text-danger" v-if="form.errors.faq_q_5">{{
              form.errors.faq_q_5
            }}</span>
          </div>
          <div class="form-group col-lg-6">
            <label for="category_id">FAQ Ans 5 </label>
            <textarea
              name=""
              id=""
              class="form-control border-gray-200"
              placeholder="Answer"
              rows="5"
              v-model="form.faq_a_5"
            ></textarea>
            <span class="text-danger" v-if="form.errors.faq_a_5">{{
              form.errors.faq_a_5
            }}</span>
          </div>
          <div class="form-group col-lg-6">
            <label for="category_id">FAQ Qus 6 </label>
            <textarea
              name=""
              id=""
              class="form-control border-gray-200"
              placeholder="Question"
              rows="5"
              v-model="form.faq_q_6"
            ></textarea>
            <span class="text-danger" v-if="form.errors.faq_q_6">{{
              form.errors.faq_q_6
            }}</span>
          </div>
          <div class="form-group col-lg-6">
            <label for="category_id">FAQ Ans 6 </label>
            <textarea
              name=""
              id=""
              class="form-control border-gray-200"
              placeholder="Answer"
              rows="5"
              v-model="form.faq_a_6"
            ></textarea>
            <span class="text-danger" v-if="form.errors.faq_a_6">{{
              form.errors.faq_a_6
            }}</span>
          </div>

          <div class="form-group col-lg-6">
            <label for="category_id">FAQ Qus 7 </label>
            <textarea
              name=""
              id=""
              class="form-control border-gray-200"
              placeholder="Question"
              rows="5"
              v-model="form.faq_q_7"
            ></textarea>
            <span class="text-danger" v-if="form.errors.faq_q_7">{{
              form.errors.faq_q_7
            }}</span>
          </div>
          <div class="form-group col-lg-6">
            <label for="category_id">FAQ Ans 7 </label>
            <textarea
              name=""
              id=""
              class="form-control border-gray-200"
              placeholder="Answer"
              rows="5"
              v-model="form.faq_a_7"
            ></textarea>
            <span class="text-danger" v-if="form.errors.faq_a_7">{{
              form.errors.faq_a_7
            }}</span>
          </div>

          <div class="form-group col-lg-6">
            <label for="active"
              >Status <span class="text-danger">*</span></label
            >

            <select
              id="active"
              class="form-control border-gray-200"
              v-model="form.status"
            >
              <option value="" disabled selected>Select Status</option>
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
              <div class="mr-2">
                <submit-button
                  :disabled="form.processing"
                  :isLoading="form.processing"
                  >Submit</submit-button
                >
              </div>
              <div class="">
                <Link
                  :href="route('admin.dry.ice.list')"
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
</template>

<script setup>
import { onMounted, onUpdated, reactive, ref } from "vue";
import { useForm, router } from "@inertiajs/vue3";
import SubmitButton from "../../../components/SubmitButton.vue";
import FileUpload from "../../../components/FileUpload.vue";
import { component as ckeditor } from "@mayasabha/ckeditor4-vue3";

const props = defineProps({
  errors: Object,
  dryice: Object,
});

onMounted(() => {
  if (props.dryice) {
    emit.emit("pageName", "Dry Ice Management", [
      { title: "Resource ", routeName: "admin.resource-list" },
      { title: "Edit Dry Ice", routeName: "" },
    ]);
  } else {
    emit.emit("pageName", "Dry Ice Management", [
      { title: "All Dry Ice bY City", routeName: "admin.resource-list" },
      { title: "Add New", routeName: "" },
    ]);
  }
});
const form = useForm({
  slug: props.dryice?.slug || "",
  status: props.dryice?.status || "",
  h1_tag: props.dryice?.h1_tag || "",
  meta_title: props.dryice?.meta_title || "",
  meta_description: props.dryice?.meta_description || "",
  city_lowercase: props.dryice?.city_lowercase || "",
  state_short_abbr: props.dryice?.state_short_abbr || "",
  city: props.dryice?.city || "",
  state_code: props.dryice?.state_code || "",
  state: props.dryice?.state || "",
  zip_codes: props.dryice?.zip_codes || "",
  type: props.dryice?.type || "",
  latitude: props.dryice?.latitude || "",
  longitude: props.dryice?.longitude || "",
  faq_q_1: props.dryice?.faq_q_1 || "",
  faq_a_1: props.dryice?.faq_a_1 || "",
  faq_q_2: props.dryice?.faq_q_2 || "",
  faq_a_2: props.dryice?.faq_a_2 || "",
  faq_q_3: props.dryice?.faq_q_3 || "",
  faq_a_3: props.dryice?.faq_a_3 || "",
  faq_q_4: props.dryice?.faq_q_4 || "",
  faq_a_4: props.dryice?.faq_a_4 || "",
  faq_q_5: props.dryice?.faq_q_5 || "",
  faq_a_5: props.dryice?.faq_a_5 || "",
  faq_q_6: props.dryice?.faq_q_6 || "",
  faq_a_6: props.dryice?.faq_a_6 || "",
  faq_q_7: props.dryice?.faq_q_7 || "",
  faq_a_7: props.dryice?.faq_a_7 || "",
});
onUpdated(() => {
  emit.emit("fileuploadmessage", props.errors.resource_image);
});
function submit() {
  if (props.dryice) {
    form.post(route("admin.edit.dry.ice", props.dryice.id));
  } else {
    form.post(route("admin.dry.ice.create"));
  }
}
</script>
<style>
.ck-editor__editable {
  min-height: 200px;
}
.seo-edit {
  margin-bottom: 15px;
  border-bottom: 1px solid #d7d8db;
}
</style>

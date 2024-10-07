<template>
  <div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__body">
      <form @submit.prevent="submit">
        <div class="form-group validated row">
          <div class="form-group col-lg-12">
            <label><b>Permalink:</b></label>
            <a> https://emory.com/{{ form.slug }}</a>
          </div>

          <div class="col-lg-12">
            <div class="form-group validated row">
              <div class="col-lg-12 mt-2 seo-edit">
                <h4>Seo Settings:</h4>
              </div>
            </div>
          </div>

          <div class="form-group col-lg-6">
            <label for="title"
              >Meta Title <span class="text-danger">*</span></label
            >
            <input
              id="title"
              v-model="form.meta_title"
              class="form-control border-gray-200"
              placeholder="Meta Title"
            />
            <span class="text-danger" v-if="form.errors.meta_title">{{
              form.errors.meta_title
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

          <div class="form-group col-lg-12">
            <label for="description"
              >Meta Description<span class="text-danger">*</span></label
            >
            <ckeditor
              v-model="form.meta_description"
              :editor="editor"
            ></ckeditor>

            <span class="text-danger" v-if="form.errors.meta_description">{{
              form.errors.meta_description
            }}</span>
          </div>
        </div>

        <div class="row" v-for="(input, k) in form.faqs" :key="k">
                <div class="form-group col-md-5">
                  <label for="include_title"
                    >FAQ Question<span class="text-danger">*</span></label
                  >
                  <input
                    type="text"
                    v-model="input.question"
                    class="form-control border-gray-200"
                    placeholder="Enter Question"
                  />
                  <span
                    class="text-danger"
                    v-if="form.errors['faqs.' + k + '.question']"
                    >{{ form.errors["faqs." + k + ".question"] }}
                  </span>
                </div>
                <div class="form-group col-md-5">
                  <label for="quantity"
                    >FAQ Answer<span class="text-danger">*</span></label
                  >
                     <textarea
                    name=""
                    col="20"
                    rows="5"
                    id=""
                    v-model="input.answer"
                    class="form-control border-gray-200"
                    placeholder="Enter Answer"
                  ></textarea>
                  <span
                    class="text-danger"
                    v-if="form.errors['faqs.' + k + '.answer']"
                    >{{ form.errors["faqs." + k + ".answer"] }}
                  </span>
                </div>

                

                <div class="col-md-2 mt-4">
                  <a
                    href="javascript:"
                    class="btn btn-primary m-2"
                    @click="addInputFaq(k)"
                    v-show="k == form.faqs.length - 1"
                    ><span>+</span>
                  </a>
                  <a
                    href="javascript:"
                    class="btn btn-primary"
                    @click="removeInputFaq(k)"
                    v-show="k || (!k && form.faqs.length > 1)"
                    ><span>-</span>
                  </a>
                </div>
              </div>

        <div class="form-group validated row">
          <div class="col-lg-12 mt-5 seo-edit">
            <h4>Page Settings:</h4>
          </div>
        </div>

        <div class="form-group validated row">
          <div class="form-group col-lg-6">
            <label for="heading">&lt;H1&gt; tag </label>
            <input
              type="text"
              id="heading"
              v-model="form.h1_tag"
              class="form-control border-gray-200"
              placeholder="<H1> tag"
            />
            <span class="text-danger" v-if="form.errors.h1_tag">{{
              form.errors.h1_tag
            }}</span>
          </div>
          <div class="form-group col-lg-6">
            <label for="heading">&lt;H2&gt; tag</label>
            <input
              type="text"
              id="title"
              v-model="form.h2_tag"
              class="form-control border-gray-200"
              placeholder="Enter <H2> tag"
            />
            <span class="text-danger" v-if="form.errors.h2_tag">{{
              form.errors.h2_tag
            }}</span>
          </div>

          <div class="form-group col-lg-12">
            <label for="category_id">&lt;Hp&gt; tag</label>
            <textarea
              name=""
              id=""
              class="form-control border-gray-200"
              v-model="form.p_tag"
              placeholder="Enter <p> tag"
              rows="5"
            ></textarea>
            <span class="text-danger" v-if="form.errors.p_tag">{{
              form.errors.p_tag
            }}</span>
          </div>

          <div class="form-group col-lg-6">
            <label for="title">Slug <span class="text-danger">*</span></label>
            <input
              id="slug"
              v-model="form.slug"
              class="form-control border-gray-200"
              placeholder="Slug"
            />
            <span class="text-danger" v-if="form.errors.title">{{
              form.errors.title
            }}</span>
          </div>

          <div class="form-group col-lg-6">
            <label>City </label>
            <input
              type="text"
              id=""
              v-model="form.city"
              class="form-control border-gray-200"
              placeholder="Enter City"
            />
            <span class="text-danger" v-if="form.errors.city">{{
              form.errors.city
            }}</span>
          </div>

          <div class="form-group col-lg-6">
            <label>State </label>
            <input
              type="text"
              id=""
              v-model="form.state"
              class="form-control border-gray-200"
              placeholder="Enter State"
            />
            <span class="text-danger" v-if="form.errors.state">{{
              form.errors.state
            }}</span>
          </div>

          <div class="form-group col-lg-6">
            <label>State Code </label>
            <input
              type="text"
              id=""
              v-model="form.state_code"
              class="form-control border-gray-200"
              placeholder="Enter State Code"
            />
            <span class="text-danger" v-if="form.errors.state_code">{{
              form.errors.state_code
            }}</span>
          </div>

          <div class="form-group col-lg-6">
            <label>Zip Codes </label>
            <input
              type="text"
              id=""
              v-model="form.zip_codes"
              class="form-control border-gray-200"
              placeholder="Enter Zip Code"
            />
            <span class="text-danger" v-if="form.errors.zip_codes">{{
              form.errors.zip_codes
            }}</span>
          </div>

          <div class="form-group col-lg-6">
            <label>Type </label>
            <input
              type="text"
              id=""
              v-model="form.type"
              class="form-control border-gray-200"
              placeholder="Enter Type"
            />
            <span class="text-danger" v-if="form.errors.type">{{
              form.errors.type
            }}</span>
          </div>

          <div class="form-group col-lg-6">
            <label>Latitude </label>
            <input
              type="number"
              id=""
              v-model="form.latitude"
              class="form-control border-gray-200"
              placeholder="Enter Latitude"
              step="0.0001"
            />
            <span class="text-danger" v-if="form.errors.latitude">{{
              form.errors.latitude
            }}</span>
          </div>

          <div class="form-group col-lg-6">
            <label>Longitude </label>
            <input
              type="number"
              id=""
              @input="validateLongitude"
              v-model="form.longitude"
              class="form-control border-gray-200"
              placeholder="Enter Longitude"
                step="0.0001"
            />
            <span class="text-danger" v-if="form.errors.longitude">{{
              form.errors.longitude
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
                <Link :href="route('admin.seo.pages')" class="btn btn-secondary"
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
import { onMounted, reactive, ref } from "vue";
import { useForm, router } from "@inertiajs/vue3";
import { component as ckeditor } from "@mayasabha/ckeditor4-vue3";
import FileUpload from "../../../components/FileUpload.vue";
import Datepicker from "../../../components/Datepicker.vue";
import SubmitButton from "../../../components/SubmitButton.vue";

const props = defineProps({
  seo: Object,
  errors: Object,
  faq : Object
});

onMounted(() => {
  // imageUrl.value = props.industry?.full_photo_url || "";
  // seoimageUrl.value = props.industry?.open_graph_image_url || "";

  emit.emit("pageName", "Seo management", [
    { title: "All Pages", routeName: "admin.cms.index" },
    { title: "Add New Page", routeName: "" },
  ]);
   
    if (props.faq.length > 0) {
      form.faqs = [];
      for (let index = 0; index < props.faq.length; index++) {
        form.faqs.push({
          question: props.faq[index].question,
          answer: props.faq[index].answer,
        });
      }
    } 
});

const form = useForm({
  faqs: [
    {
      question: "",
      answer: "",
    },
  ],
  slug: props.seo?.slug || "",
  meta_title: props.seo?.meta_title || "",
  meta_description: props.seo?.meta_description || "hi",
  status: props.seo?.status ?? "",
  p_tag: props.seo?.p_tag || "",
  h1_tag: props.seo?.h1_tag || "",
  h2_tag: props.seo?.h2_tag || "",
  city: props.seo?.city || "",
  state: props.seo?.state || "",
  state_code: props.seo?.state_code || "",
  zip_codes: props.seo?.zip_codes || "",
  type: props.seo?.type || "",
  longitude: props.seo?.longitude || 0,
  latitude: props.seo?.latitude || 0,
});

function validateLongitude() {
  const longitude = parseFloat(this.form.longitude);
  if (isNaN(longitude)) {
    this.form.errors.longitude = "Longitude should Number.";
  } else {
    this.form.errors.longitude = "";
  }
}

function submit() {
  if (props.seo) {
    form.put(`/admin/seo-page-update/${props.seo.slug}/`);
  } else {
    form.post("/admin/seo-page-create/");
  }
}

const addInputFaq = async () => {
  form.faqs.push({
    question: "",
    answer: "",
  });
};
const removeInputFaq = async (index) => {
  form.faqs.splice(index, 1);
};
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

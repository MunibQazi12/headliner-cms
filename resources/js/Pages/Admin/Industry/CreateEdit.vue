<template>
  <div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__body">
      <form @submit.prevent="submit">
        <div class="form-group validated row">
          <div class="form-group col-lg-6">
            <label for="title">Title <span class="text-danger">*</span></label>
            <input
              id="title"
              v-model="form.title"
              class="form-control border-gray-200"
              placeholder="Title"
            />
            <span class="text-danger" v-if="form.errors.title">{{
              form.errors.title
            }}</span>
          </div>
          <div class="form-group col-lg-6">
            <label>Slug <span class="text-danger">*</span></label>
            <input
              type="text"
              id=""
              v-model="form.slug"
              class="form-control border-gray-200"
              placeholder="Enter Slug"
            />
            <span class="text-danger" v-if="form.errors.slug">{{
              form.errors.slug
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
          <div class="form-group col-lg-6">
            <label for="answer"
              >Short Description <span class="text-danger">*</span></label
            >
            <textarea
              id="answer"
              v-model="form.short_description"
              class="form-control border-gray-200"
              placeholder="Answer"
            ></textarea>
            <span class="text-danger" v-if="form.errors.short_description">{{
              form.errors.short_description
            }}</span>
          </div>
          <div class="form-group col-lg-6">
            <label for="profile_photo"
              >Thumbnail<span v-if="!industry" class="text-danger"
                >*</span
              ></label
            >
            <file-upload
              @input="form.thumbnail = $event.target.files[0]"
              :imageurl="imageUrl"
            />
            <span class="text-danger" v-if="form.errors.thumbnail">{{
              form.errors.thumbnail
            }}</span>
          </div>
          <div class="form-group col-lg-12">
              <label for=""
                >Description <span class="text-danger">*</span></label
              >
              <ckeditor v-model="form.description" :editor="editor"></ckeditor>
              <span class="text-danger" v-if="form.errors.description">{{
                form.errors.description
              }}</span>
            </div>
        </div>

        <div class="form-group validated row">
          <div class="col-lg-12 mt-5 seo-edit">
            <h4>Seo Settings:</h4>
          </div>
        </div>
        <div class="form-group validated row">
          <div class="form-group col-lg-6">
            <label>H1 </label>
            <input
              type="text"
              id="title"
              v-model="form.h1"
              class="form-control border-gray-200"
              placeholder="Heading"
            />
            <span class="text-danger" v-if="form.errors.h1">{{
              form.errors.h1
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
            <label for="file">Featured Image </label>
            <file-upload
              @input="form.featured_image = $event.target.files[0]"
              :imageurl="featuredimgUrl"
            />
            <span class="text-danger" v-if="form.errors.featured_image">{{
              form.errors.featured_image
            }}</span>
          </div>

          <div class="form-group col-lg-6">
            <label>Open Graph Title </label>
            <input
              type="text"
              id=""
              v-model="form.open_graph_title"
              class="form-control border-gray-200"
              placeholder="Enter Open Graph Title"
            />
            <span class="text-danger" v-if="form.errors.open_graph_title">{{
              form.errors.open_graph_title
            }}</span>
          </div>

          <div class="form-group col-lg-6">
            <label>Open Graph Url </label>
            <input
              type="text"
              id=""
              v-model="form.open_graph_url"
              class="form-control border-gray-200"
              placeholder="Enter Open Graph Url"
            />
            <span class="text-danger" v-if="form.errors.open_graph_url">{{
              form.errors.open_graph_url
            }}</span>
          </div>

          <div class="form-group col-lg-6">
            <label for="file">OG image + X large summary card </label>
            <file-upload
              @input="form.open_graph_image = $event.target.files[0]"
              :imageurl="seoimageUrl"
            />
            <span class="text-danger" v-if="form.errors.open_graph_image">{{
              form.errors.open_graph_image
            }}</span>
          </div>

          <div class="form-group col-lg-6">
            <label for="category_id">Open Graph Description </label>
            <textarea
              name=""
              id=""
              class="form-control border-gray-200"
              placeholder="Open Graph Description"
              rows="5"
              v-model="form.open_graph_description"
            ></textarea>
            <span
              class="text-danger"
              v-if="form.errors.open_graph_description"
              >{{ form.errors.open_graph_description }}</span
            >
          </div>

          <div class="form-group col-lg-6">
            <label for="category_id">X Card Title </label>
            <input
              type="text"
              id="title"
              v-model="form.x_card_title"
              class="form-control border-gray-200"
              placeholder="Enter X Card Title"
            />
            <span class="text-danger" v-if="form.errors.x_card_title">{{
              form.errors.x_card_title
            }}</span>
          </div>

          <div class="form-group col-lg-6">
            <label>X Card Description </label>
            <textarea
              name=""
              id=""
              class="form-control border-gray-200"
              placeholder="X Card Description"
              v-model="form.x_card_description"
              rows="5"
            ></textarea>

            <span class="text-danger" v-if="form.errors.x_card_description">{{
              form.errors.x_card_description
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
                <Link :href="route('admin.industry')" class="btn btn-secondary"
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
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import FileUpload from "../../../components/FileUpload.vue";
import Datepicker from "../../../components/Datepicker.vue";
import SubmitButton from "../../../components/SubmitButton.vue";
import { component as ckeditor } from "@mayasabha/ckeditor4-vue3";

const props = defineProps({
  industry: Object,
  errors: Object,
});

const imageUrl = ref("");
const seoimageUrl = ref("");
const featuredimgUrl = ref("");

onMounted(() => {
  imageUrl.value = props.industry?.full_photo_url || "";
  seoimageUrl.value = props.industry?.open_graph_image_url || "";
  featuredimgUrl.value = props.industry?.featured_image_url || "";

  if (props.industry) {
    emit.emit("pageName", "Industry Management", [
      { title: "All Industry", routeName: "admin.industry" },
      { title: "Edit Industry", routeName: "" },
    ]);
  } else {
    emit.emit("pageName", "Industry Management", [
      { title: "All Industry", routeName: "admin.industry" },
      { title: "Add New Industry", routeName: "" },
    ]);
  }
});

const form = useForm({
  title: props.industry?.title || "",
  status: props.industry?.status || "",
  short_description: props.industry?.short_description || "",
  description: props.industry?.description || "",
  thumbnail: "",
  slug: props.industry?.slug || "",
  h1: props.industry?.h1 || "",
  meta_title: props.industry?.meta_title || "",
  meta_description: props.industry?.meta_description || "",
  open_graph_title: props.industry?.open_graph_title || "",
  open_graph_description: props.industry?.open_graph_description || "",
  open_graph_url: props.industry?.open_graph_url || "",
  open_graph_image: "",
  featured_image: "",
  x_card_title: props.industry?.x_card_title || "",
  x_card_description: props.industry?.x_card_description || "",
});

function submit() {
  if (props.industry) {
    form.post(route("admin.industry.update", props.industry.id));
  } else {
    form.post(route("admin.industry.create"));
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

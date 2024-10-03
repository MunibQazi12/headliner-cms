<template>
  <div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__body">
      <form @submit.prevent="submit">
        <div class="form-group validated row">
          <div class="form-group col-lg-6">
            <label for="title">Title <span class="text-danger">*</span></label>
            <input
              type="text"
              id="title"
              v-model="form.title"
              class="form-control border-gray-200"
              placeholder="Title"
              readonly
            />
            <span class="text-danger" v-if="form.errors.title">{{
              form.errors.title
            }}</span>
          </div>

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
          <div class="form-group col-lg-12" v-if="props.cmspage.text_content">
            <label for="content"
              >Content <span class="text-danger">*</span></label
            >
            <ckeditor v-model="form.content" :editor="editor"></ckeditor>
            <span class="text-danger" v-if="form.errors.content">{{
              form.errors.content
            }}</span>
          </div>

          <div class="form-group col-lg-6" v-if="props.cmspage.short_desc">
            <label for="short_desc">Short Description</label>
            <ckeditor v-model="form.short_desc" :editor="editor"></ckeditor>
            <span class="text-danger" v-if="form.errors.short_desc">{{
              form.errors.short_desc
            }}</span>
          </div>

          <div class="form-group col-lg-6" v-if="props.cmspage.sub_title_one">
            <label for="sub_title_one">Subtitle one</label>
            <input
              type="text"
              id="sub_title_one"
              v-model="form.sub_title_one"
              class="form-control border-gray-200"
              placeholder="Heading"
            />
            <span class="text-danger" v-if="form.errors.sub_title_one">{{
              form.errors.sub_title_one
            }}</span>
          </div>

          <div class="form-group col-lg-6" v-if="props.cmspage.sub_title_two">
            <label for="sub_title_two">Subtitle two</label>
            <input
              type="text"
              id="sub_title_two"
              v-model="form.sub_title_two"
              class="form-control border-gray-200"
              placeholder="Heading"
            />
            <span class="text-danger" v-if="form.errors.sub_title_two">{{
              form.errors.sub_title_two
            }}</span>
          </div>

          <div class="form-group col-lg-6" v-if="props.cmspage.button_text">
            <label for="button_text">Button Text</label>
            <input
              type="text"
              id="button_text"
              v-model="form.button_text"
              class="form-control border-gray-200"
              placeholder="Heading"
            />
            <span class="text-danger" v-if="form.errors.button_text">{{
              form.errors.button_text
            }}</span>
          </div>

          <div class="form-group col-lg-6" v-if="props.cmspage.button_url">
            <label for="button_url">Button Link</label>
            <input
              type="text"
              id="button_url"
              v-model="form.button_url"
              class="form-control border-gray-200"
              placeholder="Heading"
            />
            <span class="text-danger" v-if="form.errors.button_url">{{
              form.errors.button_url
            }}</span>
          </div>
        </div>

        <div class="form-group validated row">
          <div class="col-lg-12 mt-5 seo-edit">
            <h4>Seo Settings:</h4>
          </div>
        </div>
        <div class="form-group col-lg-6">
          <label for="heading">H1 </label>
          <input
            type="text"
            id="heading"
            v-model="form.heading"
            class="form-control border-gray-200"
            placeholder="Heading"
          />
          <span class="text-danger" v-if="form.errors.heading">{{
            form.errors.heading
          }}</span>
        </div>
        <div class="form-group validated row">
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
              :imageurl="featuredimageUrl"
            />
          </div>

          <div class="form-group col-lg-6">
            <label>Open Graph Title </label>
            <input
              type="text"
              id="title"
              v-model="form.open_graph_title"
              class="form-control border-gray-200"
              placeholder="Enter Open Graph Title"
            />
            <span class="text-danger" v-if="form.errors.open_graph_title">{{
              form.errors.open_graph_title
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
            <label for="open_graph_url">Open Graph Url</label>
            <input
              type="text"
              id="open_graph_url"
              v-model="form.open_graph_url"
              class="form-control border-gray-200"
              placeholder="Heading"
            />
            <span class="text-danger" v-if="form.errors.open_graph_url">{{
              form.errors.open_graph_url
            }}</span>
          </div>

          <div class="form-group col-lg-6">
            <label for="file">OG image + X large summary card </label>
            <file-upload
              @input="form.photo = $event.target.files[0]"
              :imageurl="imageUrl"
            />
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

          <!-- <div class="form-group col-lg-6">
                        <label>Canonical Url </label>
                        <input type="text" id="title" v-model="form.canonical_url" class="form-control border-gray-200"
                            placeholder="Enter Canonical Url">
                        <span class="text-danger" v-if="form.errors.canonical_url">{{ form.errors.canonical_url
                            }}</span>
                    </div> -->

          <!-- <div class="form-group col-lg-12" v-for="(schema, index) in form.schema" :key="index">
                        <div class="col-md-12 mb-4 clspn-cc mrgn-btm-sht">
                            <a href="javacript:void(0)" v-if="index >= 1" class="btn btn-secondary"
                                @click="removeInput(index)">Remove</a>
                        </div>
                        <label for="schema">Schema</label>
                        <textarea id="description" v-model="schema.schema" class="form-control border-gray-200"
                            placeholder="Schema"></textarea>
                        <p class="text-danger" v-if="errors['schema.' + index]">
                            {{ errors["schema." + index] }}
                        </p>
                    </div>
                    <div class="col-md-12 mb-4 clspn-cc mrgn-btm-sht">
                        <a href="javascript:void(0)" @click="addSchema" class="btn btn-secondary">Add Schema</a>
                    </div> -->
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
              <div>
                <Link href="/admin/cms" class="btn btn-secondary">Cancel</Link>
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
  errors: Object,
  cmspage: Object,
});
const imageUrl = ref("");
const featuredimageUrl = ref("");

const form = useForm({
  title: props.cmspage?.title || "",
  slug: props.cmspage?.slug || "",
  heading: props.cmspage?.heading || "",
  content: props.cmspage?.text_content || "",
  short_desc: props.cmspage?.short_desc || "",
  sub_title_one: props.cmspage?.sub_title_one || "",
  sub_title_two: props.cmspage?.sub_title_two || "",
  button_text: props.cmspage?.button_text || "",
  button_url: props.cmspage?.button_url || "",
  meta_title: props.cmspage?.meta_title || "",
  meta_description: props.cmspage?.meta_description || "",
  featured_image: props.cmspage?.featured_image || "",
  open_graph_title: props.cmspage?.open_graph_title || "",
  open_graph_description: props.cmspage?.open_graph_description || "",
  open_graph_url: props.cmspage?.open_graph_url || "",
  photo: props.cmspage?.photo || "",
  x_card_title: props.cmspage?.x_card_title || "",
  x_card_description: props.cmspage?.x_card_description || "",
});
console.log(imageUrl.value);
onMounted(() => {
  imageUrl.value = props.cmspage?.full_photo_url || "";
  featuredimageUrl.value = props.cmspage?.featured_image_url || "";

  emit.emit("pageName", "Content Management", [
    {
      title: "All Pages",
      routeName: "admin.cms.index",
    },
    {
      title: "Edit Page",
      routeName: "",
    },
  ]);
});

function submit() {
  if (props.cmspage) {
    form.post("/admin/cms/page/update/" + props.cmspage.id);
  } else {
    form.post("/admin/cms");
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

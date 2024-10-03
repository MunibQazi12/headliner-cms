<template>
  <div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__body">
      <form @submit.prevent="submit">
        <div class="form-group validated row">
          <div class="form-group col-lg-6">
            <label>Title <span class="text-danger">*</span></label>
            <input
              type="text"
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
            <label for="category_id"
              >Thumbnail <span class="text-danger">*</span></label
            >
            <file-upload
              @input="form.thumbnail = $event.target.files[0]"
              :imageurl="imageUrl"
            />
            <!-- <span class="text-danger" v-if="form.errors.thumbnail">{{ form.errors.thumbnail }}</span> -->
          </div>
          <div class="form-group col-lg-12">
            <label for="category_id"
              >Description <span class="text-danger">*</span></label
            >
            <ckeditor v-model="form.resource_desc" :editor="editor"></ckeditor>
            <span class="text-danger" v-if="form.errors.resource_desc">{{
              form.errors.resource_desc
            }}</span>
          </div>

          <div class="form-group validated row"></div>

          <div class="form-group validated row">
            <div class="form-group col-lg-12 mt-5 seo-edit newAdSeo_settings">
              <h4>Seo Settings:</h4>
            </div>
            <div class="form-group col-lg-6">
              <label>H1 </label>
              <input
                type="text"
                id=""
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
                placeholder="Open Graph Url"
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
                  :href="route('admin.resource-list')"
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

const imageUrl = ref("");
const seoimageUrl = ref("");
const featuredimgUrl = ref("");
const props = defineProps({
  errors: Object,
  resources: Object,
});

onMounted(() => {
  imageUrl.value = props.resources?.thumbnail || "";
  seoimageUrl.value = props.resources?.open_graph_image_url || "";
  featuredimgUrl.value = props.resources?.featured_image_url || "";
  if (props.resources) {
    emit.emit("pageName", "Resource Management", [
      { title: "Resource ", routeName: "admin.resource-list" },
      { title: "Edit Resource", routeName: "" },
    ]);
  } else {
    emit.emit("pageName", "Resource Management", [
      { title: "All Posts", routeName: "admin.resource-list" },
      { title: "Add New Post", routeName: "" },
    ]);
  }
});
const form = useForm({
  title: props.resources?.title || "",
  thumbnail: null,
  resource_desc: props.resources?.resource_desc || "",
  slug: props.resources?.slug || "",
  status: props.resources?.status || "",
  h1: props.resources?.h1 || "",
  meta_title: props.resources?.meta_title || "",
  meta_description: props.resources?.meta_description || "",
  open_graph_title: props.resources?.open_graph_title || "",
  open_graph_description: props.resources?.open_graph_description || "",
  open_graph_url: props.resources?.open_graph_url || "",
  open_graph_image: null,
  featured_image: null,
  x_card_title: props.resources?.x_card_title || "",
  x_card_description: props.resources?.x_card_description || "",
});
onUpdated(() => {
  emit.emit("fileuploadmessage", props.errors.thumbnail);
});
function submit() {
  if (props.resources) {
    form.post(route("admin.resource-edit", props.resources.id));
  } else {
    form.post(route("admin.resource-create"));
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

<template lang="">
  <div>
    <div class="kt-portlet kt-portlet--mobile">
      <div class="kt-portlet__body">
        <form @submit.prevent="submit">
          <div class="form-group validated row" v-auto-animate>
            <div class="form-group col-lg-6">
              <label for="title"
                >Enter Title<span class="text-danger">*</span></label
              >
              <input
                type="text"
                id="title"
                class="form-control border-gray-200"
                placeholder="Enter Title"
                v-model="form.title"
              />
              <span class="text-danger" v-if="form.errors.title">{{
                form.errors.title
              }}</span>
            </div>

            <div class="form-group col-lg-6">
              <label for="last_name"
                >Description <span class="text-danger">*</span></label
              >
              <textarea
                type="text"
                id="desc"
                class="form-control border-gray-200"
                placeholder="Description"
                v-model="form.desc"
              >
              </textarea>
              <span class="text-danger" v-if="form.errors.desc">{{
                form.errors.desc
              }}</span>
            </div>

            <div class="form-group col-lg-6">
              <label for="active"
                >Status <span class="text-danger">*</span></label
              >
              <select
                id="active"
                class="form-control border-gray-200"
                v-model="form.active"
              >
                <option value="">Select Status</option>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
              </select>
              <span class="text-danger" v-if="form.errors.active">{{
                form.errors.active
              }}</span>
            </div>

            <div class="form-group col-lg-6">
              <label for="file"
                >Thumbnail <span class="text-danger">*</span></label
              >
              <file-upload
                @input="form.thumbnail = $event.target.files[0]"
                :imageurl="imageUrl"
              />
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
                      :href="route('admin.category')"
                      class="btn btn-secondary"
                      >Cancel</Link
                    >
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, onUpdated, reactive, ref } from "vue";
import { useForm, router } from "@inertiajs/vue3";
import FileUpload from "../../../components/FileUpload.vue";
import SubmitButton from "../../../components/SubmitButton.vue";

const props = defineProps({
  errors: Object,
  category: Object,
});

const form = useForm({
  title: props.category?.title || null,
  desc: props.category?.desc || null,
  thumbnail: props.category?.thumbnail || null,
  active: props.category?.active || "",
});

onUpdated(() => {
  emit.emit("fileuploadmessage", props.errors.thumbnail);
});

const imageUrl = ref("");

onMounted(() => {
  imageUrl.value = props.category?.category_image_url || "";
  if (props.category) {
    emit.emit("pageName", "Category Management", [
      {
        title: "Category List",
        routeName: "admin.category",
      },
      {
        title: "Edit Category",
        routeName: "",
      },
    ]);
  } else {
    emit.emit("pageName", "Category Management", [
      {
        title: "Category List",
        routeName: "admin.category",
      },
      {
        title: "Add Category",
        routeName: "",
      },
    ]);
  }
});

function submit() {
  if (props.category) {
    form.post(route("admin.editCategory", props.category.id));
  } else {
    form.post(route("admin.createCategory"));
  }
}
</script>

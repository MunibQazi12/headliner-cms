<template lang="">
  <div>
    <Head title="Create Dealer" v-if="!props.user" />
    <Head title="Edit Dealer" v-if="props.user" />
    <div class="kt-portlet kt-portlet--mobile">
      <div class="kt-portlet__body">
        <form @submit.prevent="submit">
          <div class="form-group validated row" v-auto-animate>
            <div class="form-group col-lg-6">
              <label for="title"
                >Title <span class="text-danger">*</span></label
              >
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

            <div class="form-group col-lg-6">
              <label for="profile_photo"
                >Thumbnail
                <span v-if="!choose_for" class="text-danger">*</span></label
              >
              <file-upload
                @input="form.photo = $event.target.files[0]"
                :imageurl="imageUrl"
              />
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
                    :href="route('admin.choose-for')"
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
<script setup>
import { onMounted, onUpdated, reactive, ref } from "vue";
import { useForm, router } from "@inertiajs/vue3";
import FileUpload from "../../../components/FileUpload.vue";
import Datepicker from "../../../components/Datepicker.vue";
import SubmitButton from "../../../components/SubmitButton.vue";

const props = defineProps({
  errors: Object,
  choose_for: Object,
});

const form = useForm({
  title: props.choose_for?.title || null,
  status: props.choose_for?.status || "",
  photo: null,
});

onUpdated(() => {
  emit.emit("fileuploadmessage", props.errors.photo);
});

const imageUrl = ref("");

onMounted(() => {
  imageUrl.value = props.choose_for?.full_photo_url || "";
  if (props.choose_for) {
    emit.emit("pageName", "Resource Management", [
      {
        title: "Choose For List",
        routeName: "admin.choose-for",
      },
      {
        title: "Edit Choose For",
        routeName: "",
      },
    ]);
  } else {
    emit.emit("pageName", "Resource Management", [
      {
        title: "Choose For List",
        routeName: "admin.choose-for",
      },
      {
        title: "Add Choose For",
        routeName: "",
      },
    ]);
  }
});

function submit() {
  if (props.choose_for) {
    form.post(route("admin.edit-choose-for", props.choose_for.id));
  } else {
    form.post(route("admin.create-choose-for"));
  }
}
</script>
<style lang=""></style>

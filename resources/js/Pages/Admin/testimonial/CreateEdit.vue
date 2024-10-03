<template>
  <div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__body">
      <form @submit.prevent="submit">
        <div class="form-group validated row">
          <div class="form-group col-lg-6">
            <label for="question"
              >Username <span class="text-danger">*</span></label
            >
            <input
              type="text"
              id="title"
              v-model="form.username"
              class="form-control border-gray-200"
              placeholder="Username"
            />
            <span class="text-danger" v-if="form.errors.username">{{
              form.errors.username
            }}</span>
          </div>
          <div class="form-group col-lg-6">
            <label for="category_id"
              >Rating <span class="text-danger">*</span></label
            >
            <select class="form-control border-gray-200" v-model="form.rating">
              <option value="">Select Rating</option>
              <option v-for="n in ratings" :key="n" :value="n">{{ n }}</option>
            </select>
            <span class="text-danger" v-if="form.errors.rating">{{
              form.errors.rating
            }}</span>
          </div>
          <div class="form-group col-lg-12">
            <label for="category_id"
              >Review <span class="text-danger">*</span></label
            >
            <textarea
              rows="4"
              type="text"
              id="title"
              v-model="form.description"
              class="form-control border-gray-200"
              placeholder="Review"
            ></textarea>
            <span class="text-danger" v-if="form.errors.description">{{
              form.errors.description
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
                  :href="route('admin.testimonial')"
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
import { onMounted, reactive, ref } from "vue";
import { useForm, router } from "@inertiajs/vue3";
import SubmitButton from "../../../components/SubmitButton.vue";

const props = defineProps({
  errors: Object,
  testimonial: Object,
});
const ratings = ref([1, 2, 3, 4, 5]);

onMounted(() => {
  if (props.testimonial) {
    emit.emit("pageName", "Resource Management", [
      { title: "All Reviews", routeName: "admin.testimonial" },
      { title: "Edit Testimonial", routeName: "" },
    ]);
  } else {
    emit.emit("pageName", "Resource Management", [
      { title: "All Reviews", routeName: "admin.testimonial" },
      { title: "Add Review", routeName: "" },
    ]);
  }
});
const form = useForm({
  username: props.testimonial?.username || "",
  description: props.testimonial?.description || "",
  rating: props.testimonial?.rating || "",
});

function submit() {
  if (props.testimonial) {
    form.post(route("admin.testimonial.update", props.testimonial.id));
  } else {
    form.post(route("admin.testimonial.create-post"));
  }
}
</script>

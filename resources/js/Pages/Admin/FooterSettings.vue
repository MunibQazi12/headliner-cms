<template>
  <Head title="Footer Settings" />
  <div class="kt-portlet kt-portlet--mobile">
    <div class="kt-portlet__body">
      <h2>Footer Settings</h2>
      <form @submit.prevent="submit">
        <div class="form-group validated row">
          <div class="form-group col-lg-6">
            <label for="sales_contact">Sales Contact</label>
            <input
              type="text"
              id="sales_contact"
              v-model="form.sales_contact"
              class="form-control border-gray-200"
              placeholder="Sales Contact"
            />
            <span class="text-danger" v-if="form.errors.sales_contact">{{
              form.errors.sales_contact
            }}</span>
          </div>
          <div class="form-group col-lg-6">
            <label for="support_contact">Support Contact</label>
            <input
              type="text"
              id="support_contact"
              v-model="form.support_contact"
              class="form-control border-gray-200"
              placeholder="Support Contact"
            />
            <span class="text-danger" v-if="form.errors.support_contact">{{
              form.errors.support_contact
            }}</span>
          </div>
          <div class="form-group col-lg-6">
            <label for="facebook_link">Facebook Link</label>
            <input
              type="text"
              id="facebook_link"
              v-model="form.facebook_link"
              class="form-control border-gray-200"
              placeholder="Facebook Link"
            />
            <span class="text-danger" v-if="form.errors.facebook_link">{{
              form.errors.facebook_link
            }}</span>
          </div>
          <div class="form-group col-lg-6">
            <label for="twitter_link">Twitter Link</label>
            <input
              type="text"
              id="twitter_link"
              v-model="form.twitter_link"
              class="form-control border-gray-200"
              placeholder="Twitter Link"
            />
            <span class="text-danger" v-if="form.errors.twitter_link">{{
              form.errors.twitter_link
            }}</span>
          </div>
          <div class="form-group col-lg-6">
            <label for="linkedin_link">Linkedin Link</label>
            <input
              type="text"
              id="linkedin_link"
              v-model="form.linkedin_link"
              class="form-control border-gray-200"
              placeholder="Linkedin Link"
            />
            <span class="text-danger" v-if="form.errors.linkedin_link">{{
              form.errors.linkedin_link
            }}</span>
          </div>
          <div class="form-group col-lg-12">
            <label for="mission_statement"
              >Mission Statement</label
            >
            <textarea
              rows="4"
              type="text"
              id="mission_statement"
              v-model="form.mission_statement"
              class="form-control border-gray-200"
              placeholder="Mission Statement"
            ></textarea>
            <span class="text-danger" v-if="form.errors.mission_statement">{{
              form.errors.mission_statement
            }}</span>
          </div>
         

          <div class="kt-portlet__foot">
            <div class="kt-form__actions">
              <div class="row">
                <div class="col-lg-6">
                  <submit-button
                    :disabled="form.processing"
                    :isLoading="form.processing"
                    >Submit</submit-button
                  >
                </div>
                <div class="col-lg-6 kt-align-right">
                  <Link
                    :href="route('admin.dashboard')"
                    class="btn btn-danger btn-secondary"
                    >Back</Link
                  >
                </div>
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
import FileUpload from "../../components/FileUpload.vue";
import SubmitButton from "../../components/SubmitButton.vue";
import AdminChangePassword from "./AdminChangePassword.vue";

const props = defineProps({
  errors: Object,
  footerSettings: Object,
});

const form = useForm({
  sales_contact: props.footerSettings?.filter((setting) => setting.key == "sales_contact")[0]?.value || null,
  support_contact:  props.footerSettings?.filter((setting) => setting.key == "support_contact")[0]?.value  || null,
  facebook_link:  props.footerSettings?.filter((setting) => setting.key == "facebook_link")[0]?.value  || null,
  twitter_link:  props.footerSettings?.filter((setting) => setting.key == "twitter_link")[0]?.value  || null,
  linkedin_link:  props.footerSettings?.filter((setting) => setting.key == "linkedin_link")[0]?.value  || null,
  mission_statement:  props.footerSettings?.filter((setting) => setting.key == "mission_statement")[0]?.value  || null,

});

const imageUrl = ref("");

onMounted(() => {
  imageUrl.value = props.user?.profile_photo_url || "";
  emit.emit("pageName", "Footer Settings", [
    { title: "Footer Settings", routeName: "admin.footer-settings" },
  ]);
});

function submit() {
  form.post(route("admin.footer-settings"));
}
</script>

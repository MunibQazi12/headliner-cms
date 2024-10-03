<template lang="">
  <div class="welcome_scr login-wpr">
    <!-- <img :src="'/admin_assets/login-bg.jpg'" alt="" class="login-bg-img"> -->
    <div class="login-row g-0">
      <div class="login-form-col">
        <div class="scr_body login-form-wpr">
          <div class="src_logo_area">
            <a href="/admin/login" class=""
              ><img :src="'/admin_assets/emory.png'" alt=""
            /></a>
          </div>
          <h1 class="card-title">OTP Validations</h1>

          <form @submit.prevent="submit">
            <div class="form-group">
              <label for="email">Email</label>
              <input
                type="email"
                id="email"
                :value="email"
                class="form-control"
                placeholder="Email"
                readonly
              />
              <span class="text-danger" v-if="form.errors.email">{{
                form.errors.email
              }}</span>
            </div>
            <div class="form-group">
              <label for="otp">OTP</label>
              <input
                type="text"
                id="otp"
                v-model="form.otp"
                class="form-control"
                placeholder="OTP"
              />
              <span class="text-danger" v-if="form.errors.otp">{{
                form.errors.otp
              }}</span>
            </div>
            <submit-button :isLoading="form.processing">Submit</submit-button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, reactive, ref } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";
import SubmitButton from "../../components/SubmitButton.vue";

const props = defineProps({
  errors: Object,
  email: String,
});

const form = useForm({
  email: props.email,
  otp: "",
});

onMounted(() => {});

function submit() {
  form.post("/admin/otp-validations");
}
</script>
<style>
@import "/public/admin_assets/custom.css";
</style>

<template lang="">
  <div class="welcome_scr login-wpr">
    <!-- <img :src="'/admin_assets/login-bg.jpg'" alt="" class="login-bg-img"> -->
    <div class="login-row">
      <div class="login-form-col">
        <div class="scr_body login-form-wpr">
          <div class="src_logo_area">
            <a href="/admin/login" class=""
              ><img :src="'/admin_assets/emory.png'" alt=""
            /></a>
          </div>
          <h1 class="card-title">Forgot Password</h1>

          <form @submit.prevent="submit">
            <div class="form-group nogap">
              <label for="email">Email</label>
              <input
                type="email"
                id="email"
                v-model="form.email"
                class="form-control"
                placeholder="Email"
              />
              <span class="text-danger" v-if="form.errors.email">{{
                form.errors.email
              }}</span>
            </div>
            <div class="scr_footer">
              <button type="submit" class="btn" :disabled="form.processing">
                Submit
              </button>
              <Link href="/admin/login" class="btn float-right">Back</Link>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { reactive, ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";
import SubmitButton from "../../components/SubmitButton.vue";

const form = useForm({
  email: "",
});

defineProps({
  errors: Object,
});

function submit() {
  form.post("/admin/forgot-password");
}
</script>
<style>
@import "/public/admin_assets/custom.css";
</style>

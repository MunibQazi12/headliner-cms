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
          <h1 class="card-title">Admin Login</h1>

          <form @submit.prevent="submit">
            <div class="form-group">
              <label for="email"
                >Email <span class="text-danger">*</span></label
              >
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

            <div class="form-group">
              <label for="password"
                >Password <span class="text-danger">*</span></label
              >
              <div class="password_box">
                <input
                  :type="showPassword ? 'text' : 'password'"
                  id="password"
                  v-model="form.password"
                  class="form-control"
                  placeholder="Password"
                />
                <div class="control">
                  <span class="icon is-small is-right">
                    <i
                      @click="toggleShow"
                      class="fas"
                      :class="{
                        'fa-eye-slash': showPassword,
                        'fa-eye': !showPassword,
                      }"
                    ></i>
                  </span>
                </div>
              </div>
              <span class="text-danger" v-if="form.errors.password">{{
                form.errors.password
              }}</span>
            </div>

            <div class="scr_footer">
              
              <button type="submit" class="btn" :disabled="form.processing" style="margin:15px 0">
                Login
              </button>
              <Link :href="route('admin.forgotPassword')"
                >Forgot Password?</Link
              >
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
  email: null,
  password: null,
});

defineProps({
  errors: Object,
});

function submit() {
  form.post("/admin/login");
}

const showPassword = ref(false);

const toggleShow = async () => {
  showPassword.value = !showPassword.value;
};
</script>

<style>
@import "/public/admin_assets/custom.css";
</style> 

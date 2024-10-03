<template lang="">
  <div class="welcome_scr login-wpr">
    <!-- <img :src="'/admin_assets/login-bg.jpg'" alt="" class="login-bg-img"> -->
    <div class="login-row g-0">
      <div class="login-form-col">
        <div class="scr_body login-form-wpr">
          <div class="src_logo_area">
            <a href="/admin/login" class="">
              <img :src="'/admin_assets/emory.png'" alt="" />
            </a>
          </div>
          <h1 class="card-title">Reset Password</h1>

          <form @submit.prevent="submit">
            <div class="form-group">
              <label for="password">Password</label>
              <div class="password_box">
                <input
                  :type="showPassword ? 'text' : 'password'"
                  id="password"
                  class="form-control"
                  placeholder="Password"
                  v-model="form.password"
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

            <div class="form-group">
              <label for="confirmPassword">Confirm Password</label>
              <div class="password_box">
                <input
                  :type="showPassword2 ? 'text' : 'password'"
                  id="confirmPassword"
                  class="form-control"
                  placeholder="Confirm Password"
                  v-model="form.confirm_password"
                />
                <div class="control">
                  <span class="icon is-small is-right">
                    <i
                      @click="toggleShow2"
                      class="fas"
                      :class="{
                        'fa-eye-slash': showPassword2,
                        'fa-eye': !showPassword2,
                      }"
                    ></i>
                  </span>
                </div>
              </div>
              <span class="text-danger" v-if="form.errors.confirm_password">{{
                form.errors.confirm_password
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

const form = useForm({
  password: "",
  confirm_password: "",
});

onMounted(() => {
  // if(usePage().props.flash.success){
  //   toaster.success(usePage().props.flash.success);
  // }
  // if(usePage().props.flash.error){
  //   toaster.error(usePage().props.flash.error);
  // }
});

const props = defineProps({
  errors: Object,
  email: String,
});

function submit() {
  form.post("/admin/reset-password");
}

const showPassword = ref(false);
const showPassword2 = ref(false);

const toggleShow = async () => {
  showPassword.value = !showPassword.value;
};

const toggleShow2 = async () => {
  showPassword2.value = !showPassword2.value;
};
</script>
<style>
@import "/public/admin_assets/custom.css";
</style>

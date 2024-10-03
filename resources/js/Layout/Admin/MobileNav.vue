<template lang="">
  <div id="kt_header_mobile" class="kt-header-mobile kt-header-mobile--fixed">
    <div class="kt-header-mobile__logo">
      <Link :href="route('admin.dashboard')" class="logo_text_custom">
        <img
          :src="'/admin_assets/emory-white.png'"
          alt=""
          style="width: 121px; height: 25px; margin-top: 10px"
        />
      </Link>
    </div>
    <div class="kt-header-mobile__toolbar">
      <button
        class="kt-header-mobile__toggler kt-header-mobile__toggler--left"
        :class="hideShow ? 'kt-header-mobile__toolbar-toggler--active' : ''"
        id="kt_aside_mobile_toggler"
        @click="toggleMobileMenu"
      >
        <span></span>
      </button>
      <button
        class="kt-header-mobile__topbar-toggler"
        id="kt_header_mobile_topbar_toggler"
        @click="toggleProfileMobileMenu"
      >
        <i class="flaticon-more"></i>
      </button>
    </div>
  </div>
</template>
<script setup>
import { ref } from "vue";

const hideShow = ref(false);
const profileMenu = ref(false);
const toggleMobileMenu = () => {
  hideShow.value = !hideShow.value;
  emit.emit("toggleMobileMenu", hideShow.value);
};

const toggleProfileMobileMenu = () => {
  profileMenu.value = !profileMenu.value;
  emit.emit("toggleProfileMobileMenu", profileMenu.value);
};
</script>
<style lang=""></style>

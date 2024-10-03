<template lang="">
  <div id="kt_header" class="kt-header kt-grid__item kt-header--fixed">
    <!-- begin:: Header Menu -->
    <button
      class="kt-header-menu-wrapper-close"
      id="kt_header_menu_mobile_close_btn"
    >
      <i class="la la-close"></i>
    </button>
    <div class="kt-header-menu-wrapper" id="kt_header_menu_wrapper">
      <div
        id="kt_header_menu"
        class="kt-header-menu kt-header-menu-mobile kt-header-menu--layout-default"
      >
        <ul class="kt-menu__nav">
          <li
            class="kt-menu__item kt-menu__item--submenu kt-menu__item--rel kt-menu__item--active"
            data-ktmenu-submenu-toggle="click"
            aria-haspopup="true"
          >
            <a href="javascript:void(0);" class="kt-menu__link kt-menu__toggle"
              ><span class="kt-menu__link-text">{{ title }}</span></a
            >
          </li>
        </ul>
      </div>
    </div>
    <!-- end:: Header Menu -->

    <!-- begin:: Header Topbar -->
    <div class="kt-header__topbar">
      <!--begin: Quick Actions -->
      <div class="kt-header__topbar-item dropdown">
        <div
          class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-xl"
        >
          <form>
            <!--begin: Head -->
            <div
              class="kt-head kt-head--skin-dark"
              style="background-image: admin_assets/media/misc/bg-1.jpg"
            >
              <h3 class="kt-head__title">
                User Quick Actions
                <span class="kt-space-15"></span>
                <span class="btn btn-success btn-sm btn-bold btn-font-md"
                  >23 tasks pending</span
                >
              </h3>
            </div>
            <!--end: Head -->
          </form>
        </div>
      </div>

      <!--begin: User Bar -->
      <div class="kt-header__topbar-item kt-header__topbar-item--user">
        <div
          class="kt-header__topbar-wrapper"
          data-toggle="dropdown"
          data-offset="0px,0px"
        >
          <div class="kt-header__topbar-user admin_prifileDtls">
            <!-- <span class="kt-header__topbar-welcome kt-hidden-mobile">Hi,</span>
                <span
                    class="kt-header__topbar-username kt-hidden-mobile">{{$page.props.auth.user.full_name}}</span> -->
            <img
              class=""
              alt="Pic"
              :src="$page.props.auth.user?.profile_photo_url"
            />

            <!--use below badge element instead the user avatar to display username's first letter(remove kt-hidden class to display it) -->
            <span
              class="kt-badge kt-badge--username kt-badge--unified-success kt-badge--lg kt-badge--rounded kt-badge--bold"
            >
              {{ $page.props.auth.user.full_name }}</span
            >
          </div>
        </div>
        <!-- <div
            class="dropdown-menu headerProfileDropDown dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-xl">


            <div class="kt-user-card kt-user-card--skin-dark kt-notification-item-padding-x"
                style="background-image:admin_assets/media/misc/bg-1.jpg">
                <div class="kt-user-card__avatar">
                    <img class="" alt="Pic" :src="$page.props.auth.user?.profile_photo_url" />


                    <span
                        class="kt-hidden kt-badge kt-badge--lg kt-badge--rounded kt-badge--bold kt-font-success ">AA</span>
                </div>
                <div class="kt-user-card__name">
                    {{$page.props.auth.user.full_name}}
                </div>

            </div>


        </div> -->
      </div>
      <!--end: User Bar -->
    </div>
    <!-- end:: Header Topbar -->
  </div>
</template>

<script setup>
import { computed, ref } from "vue";
import { usePage } from "@inertiajs/vue3";
import { onMounted } from "vue";

const title = ref("");
onMounted(() => {
  emit.on("pageName", function (arg1) {
    title.value = arg1;
  });
});

const user = computed(() => usePage().props.auth.user);
</script>
<style lang=""></style>

<template>
  <div class="dashboard-menu-toggle" @click="toggleSide = !toggleSide">
    <img src="frontend_assets/images/menu-bar.png" alt="" v-if="toggleSide" />
    <img src="frontend_assets/images/close-popup.svg" alt="" v-else />
  </div>
  <div
    class="dashboard-left dashboard-left-main"
    :class="toggleSide ? 'hide' : ''"
  >
    <div class="dashboard-left-wpr">
      <div class="dashboard-left-upper">
        <ul class="dashboard-left-upper-list">
          <li :class="$page.props.current_url == 'my-profile' ? 'active' : ''">
            <Link :href="route('frontend.my-profile')">
              <span class="dash-left-icon">
                <img
                  src="frontend_assets/images/dash-icon-1a.svg"
                  alt=""
                  class="dash-left-icon-a"
                />
                <img
                  src="frontend_assets/images/dash-icon-1b.svg"
                  alt=""
                  class="dash-left-icon-b"
                />
              </span>
              My Profile
            </Link>
          </li>

          <li
            :class="
              $page.props.current_url == 'user-natal-chart' ? 'active' : ''
            "
          >
            <Link :href="route('frontend.user-natal-chart')">
              <span class="dash-left-icon">
                <Icon
                  icon="gg:chart"
                  color="#f0b56c"
                  width="17"
                  height="17"
                  class="dash-left-icon-a"
                />
                <Icon
                  icon="gg:chart"
                  color="black"
                  width="17"
                  height="17"
                  class="dash-left-icon-b"
                />
              </span>
              Your Natal Chart
            </Link>
          </li>

          <li
            :class="
              $page.props.current_url == 'user-tarot-reading' ? 'active' : ''
            "
          >
            <Link :href="route('frontend.user-tarot-reading')">
              <span class="dash-left-icon">
                <Icon
                  icon="streamline:cards"
                  color="#f0b56c"
                  width="17"
                  height="17"
                  class="dash-left-icon-a"
                />
                <Icon
                  icon="streamline:cards"
                  color="black"
                  width="17"
                  height="17"
                  class="dash-left-icon-b"
                />
              </span>
              Tarot Reading
            </Link>
          </li>

          <li :class="$page.props.current_url == 'user-love' ? 'active' : ''">
            <Link :href="route('frontend.user-love')">
              <span class="dash-left-icon">
                <Icon
                  icon="mingcute:love-fill"
                  color="#f0b56c"
                  width="20"
                  height="20"
                  class="dash-left-icon-a"
                />
                <Icon
                  icon="mingcute:love-fill"
                  color="black"
                  width="20"
                  height="20"
                  class="dash-left-icon-b"
                />
              </span>
              Love Compatibility
            </Link>
          </li>

          <li
            :class="$page.props.current_url == 'user-horoscope' ? 'active' : ''"
          >
            <Link :href="route('frontend.user.horoscope')">
              <span class="dash-left-icon">
                <Icon
                  icon="mdi:horoscope-scorpio"
                  color="#f0b56c"
                  width="20"
                  height="20"
                  class="dash-left-icon-a"
                />
                <Icon
                  icon="mdi:horoscope-scorpio"
                  color="black"
                  width="20"
                  height="20"
                  class="dash-left-icon-b"
                />
              </span>
              Horoscope
            </Link>
          </li>

          <li
            :class="
              $page.props.current_url == 'user-numerology' ? 'active' : ''
            "
          >
            <Link :href="route('frontend.user.numerology')">
              <span class="dash-left-icon">
                <Icon
                  icon="fa-solid:sort-numeric-down"
                  color="#f0b56c"
                  width="17"
                  height="17"
                  class="dash-left-icon-a"
                />
                <Icon
                  icon="fa-solid:sort-numeric-down"
                  color="black"
                  width="17"
                  height="17"
                  class="dash-left-icon-b"
                />
              </span>
              Numerology
            </Link>
          </li>

          <li
            :class="$page.props.current_url == 'order-details' ? 'active' : ''"
          >
            <Link :href="route('frontend.order-details')">
              <span class="dash-left-icon">
                <img
                  src="frontend_assets/images/dash-icon-2a.svg"
                  alt=""
                  class="dash-left-icon-a"
                />
                <img
                  src="frontend_assets/images/dash-icon-2b.svg"
                  alt=""
                  class="dash-left-icon-b"
                />
              </span>
              Order Details
            </Link>
          </li>

          <li
            :class="
              $page.props.current_url == 'payment-details' ? 'active' : ''
            "
          >
            <Link :href="route('frontend.payment-details')">
              <span class="dash-left-icon">
                <img
                  src="frontend_assets/images/dash-icon-3a.svg"
                  alt=""
                  class="dash-left-icon-a"
                />
                <img
                  src="frontend_assets/images/dash-icon-3b.svg"
                  alt=""
                  class="dash-left-icon-b"
                />
              </span>
              Payment Details
            </Link>
          </li>
          <li :class="$page.props.current_url == 'setting' ? 'active' : ''">
            <Link :href="route('frontend.setting')">
              <span class="dash-left-icon">
                <img
                  src="frontend_assets/images/dash-icon-4a.svg"
                  alt=""
                  class="dash-left-icon-a"
                />
                <img
                  src="frontend_assets/images/dash-icon-4b.svg"
                  alt=""
                  class="dash-left-icon-b"
                />
              </span>
              Settings
            </Link>
          </li>
        </ul>
      </div>
      <div class="dashboard-left-lower">
        <a href="javascript:void(0)" class="dash-signout" @click="show_logout">
          Sign Out
          <span class="dash-left-icon">
            <img
              src="frontend_assets/images/signout-1.svg"
              alt=""
              class="dash-left-icon-a"
            />
          </span>
        </a>
      </div>
    </div>

    <div class="signout-popup" :class="logout_modal ? 'show' : ''">
      <div class="signout-popup-wrap">
        <div class="container">
          <div class="signout-popup-box">
            <figure class="signout-icon">
              <img src="frontend_assets/images/signout-logo.svg" alt="" />
            </figure>
            <h2>Are you sure you want to logout?</h2>
            <div class="signout-popup-btn">
              <a href="/logout" class="cmn-btn yes">Yes</a>
              <a href="#url" @click="hide_modal" class="cancel cmn-btn"
                >Cancel</a
              >
            </div>
            <span @click="hide_modal" class="signout-popup-close"
              ><img src="frontend_assets/images/close-popup.svg" alt=""
            /></span>
          </div>
        </div>
      </div>
      <img
        src="frontend_assets/images/popup-blur-1.svg"
        alt=""
        class="popup-blur-1"
      />
      <img
        src="frontend_assets/images/popup-blur-2.svg"
        alt=""
        class="popup-blur-2"
      />
    </div>
  </div>
</template>
<script setup>
import { ref } from "vue";

const logout_modal = ref(false);
const toggleSide = ref(true);

const show_logout = async () => {
  logout_modal.value = true;
};
const hide_modal = async () => {
  logout_modal.value = false;
};
</script>
<style>
.hide {
  display: none;
}
</style>

<template>
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6">
        <div class="half-media">
          <img
            src="frontend_assets/images/et-line1.svg"
            class="et-line-f"
            alt=""
          />
          <svg
            class="el-f"
            width="465"
            height="465"
            viewBox="0 0 465 465"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <circle
              opacity="0.69"
              cx="232.5"
              cy="232.5"
              r="232.5"
              transform="matrix(-1 0 0 1 465 0)"
              fill="url(#paint0_radial_212_1098)"
            />
            <defs>
              <radialGradient
                id="paint0_radial_212_1098"
                cx="0"
                cy="0"
                r="1"
                gradientUnits="userSpaceOnUse"
                gradientTransform="translate(243.644 246.176) scale(236.57 236.565)"
              >
                <stop offset="0" stop-color="#F1C48C" />
                <stop offset="1" stop-color="#672EA9" stop-opacity="0" />
              </radialGradient>
            </defs>
          </svg>
          <svg
            class="el-s"
            width="596"
            height="596"
            viewBox="0 0 596 596"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <circle
              opacity="0.69"
              cx="298"
              cy="298"
              r="298"
              fill="url(#paint0_radial_212_1097)"
            />
            <defs>
              <radialGradient
                id="paint0_radial_212_1097"
                cx="0"
                cy="0"
                r="1"
                gradientUnits="userSpaceOnUse"
                gradientTransform="translate(312.283 315.529) scale(303.217 303.21)"
              >
                <stop offset="0" stop-color="#EDB064" />
                <stop offset="1" stop-color="#672EA9" stop-opacity="0" />
              </radialGradient>
            </defs>
          </svg>
          <img
            :src="
              $page.props.frontendUrl + '/' + props.cms?.expert_support?.image
            "
            class="half-media-main-image"
            alt=""
            data-aos="zoom-in"
          />
          <img
            src="frontend_assets/images/star1.svg"
            class="star-first"
            alt=""
          />
          <img src="frontend_assets/images/star2.svg" class="star-sec" alt="" />
          <img src="frontend_assets/images/cloud1.png" class="cloud-f" alt="" />
          <img
            src="frontend_assets/images/cloud-2.png"
            class="cloud-sec"
            alt=""
          />
          <img src="frontend_assets/images/cloud3.png" class="cloud-t" alt="" />
        </div>
      </div>
      <div class="col-lg-6">
        <div class="half-media-content" data-aos="fade-up">
          <h2>{{ props.cms?.expert_support?.title }}</h2>
          <p>{{ props.cms?.expert_support?.description }}</p>
          <a class="cmn-btn" href="/lets-begin">Get my predictions</a>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
const props = defineProps({
  cms: Object,
});
</script>

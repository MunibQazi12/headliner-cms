<template>
  <div class="container">
    <h2 data-aos="fade-up">Trusted by</h2>
    <div class="logo-brand-lists">
      <div class="splide brand-splide">
        <div class="splide__track">
          <div class="splide__list">
            <div class="splide__slide" v-for="trust in trusts">
              <div class="brand-slide-box">
                <img
                  :src="
                    trust?.image_full_path
                      ? trust?.image_full_path
                      : trust?.thumbnail
                  "
                  class="brand-slide-img"
                  alt=""
                />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
const props = defineProps({
  trusts: Object,
});
</script>

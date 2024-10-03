<template>
  <div class="container">
    <div class="row counter-row" id="counter">
      <div class="col-lg-4 col-sm-6 counter-col" data-aos="fade-up">
        <img
          class="count-img"
          src="frontend_assets/images/count-img1.svg"
          alt=""
        />
        <span class="num-count">
          <span class="count" :data-count="props.cms?.total_count[0]?.title">
            0 </span
          >+
        </span>
        <p>
          {{ props.cms?.total_count[0]?.description }}
        </p>
      </div>
      <div
        class="col-lg-4 col-sm-6 counter-col"
        data-aos="fade-up"
        data-aos-delay="200"
      >
        <img
          class="count-img"
          src="frontend_assets/images/count-img2.svg"
          alt=""
        />
        <span class="num-count">
          <span class="count" :data-count="props.cms?.total_count[1]?.title">
            0 </span
          >%
        </span>
        <p>
          {{ props.cms?.total_count[1]?.description }}
        </p>
      </div>
      <div
        class="col-lg-4 col-sm-6 counter-col"
        data-aos="fade-up"
        data-aos-delay="300"
      >
        <img
          class="count-img"
          src="frontend_assets/images/count-img3.svg"
          alt=""
        />
        <span class="num-count">
          <span class="count" :data-count="props.cms?.total_count[2]?.title">
            0 </span
          >+
        </span>
        <p>
          {{ props.cms?.total_count[2]?.description }}
        </p>
      </div>
    </div>
  </div>
</template>
<script setup>
const props = defineProps({
  cms: Object,
});
</script>

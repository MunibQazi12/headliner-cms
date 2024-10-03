<template>
  <div class="testimonial-lists">
    <div class="testimonial-slider">
      <div class="testimonial-slider-slide" v-for="test in testiMonials">
        <div class="testimonial-slide-box">
          <div class="testimonial-slide-header">
            <div class="testimonial-user">
              <img
                :src="
                  test?.image_full_path
                    ? test?.image_full_path
                    : test?.thumbnail
                "
                class="testimonial-user-dp"
                alt=""
              />
              <div class="testimonial-user-desc">
                <div class="testimonial-user-name">{{ test?.name }}</div>
                <div class="testimonial-date">
                  <timeago :datetime="test?.updated_at" />
                </div>
              </div>
            </div>
            <div class="testimonial-user-rating">
              <span
                v-for="n in 5"
                :key="n"
                class="star"
                :class="{
                  filled: n <= Math.round(test?.rating),
                }"
                >&#9733;</span
              >
            </div>
          </div>
          <div class="testimonial-slide-body">
            <p>
              {{
                test?.description.length > 320
                  ? test?.description.substring(0, 320) + "...."
                  : test?.description
              }}
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
const props = defineProps({
  testiMonials: Object,
});
</script>
<style>
.star {
  color: #ccc;
}

.filled {
  color: gold;
}
</style>

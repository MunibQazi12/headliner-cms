<template>
  <VueDatePicker
    :format="format"
    placeholder="Choose Date"
    :model-value="date"
    @update:model-value="handleDate"
    auto-apply
    @cleared="clearData"
    :enable-time-picker="false"
  />
</template>

<script setup>
import { computed, onMounted, ref } from "vue";
import VueDatePicker from "@vuepic/vue-datepicker"; // https://vue3datepicker.com/props/modes/
import "@vuepic/vue-datepicker/dist/main.css";
import moment from "moment";
import { usePage } from "@inertiajs/vue3";

const { modelValue } = defineProps(["modelValue"]);
const emit1 = defineEmits(["update:modelValue"]);

const date = ref();
date.value = modelValue;

const adminFormat = computed(() => usePage().props.dateFormat);
const format = ref("MM/dd/yyyy");

onMounted(() => {
  if (adminFormat.value == "DD/MM/YYYY") {
    format.value = "dd/MM/yyyy";
  }
  if (adminFormat.value == "MM/DD/YYYY") {
    format.value = "MM/dd/yyyy";
  }
  if (adminFormat.value == "YYYY/MM/DD") {
    format.value = "yyyy/MM/dd";
  }
});

const handleDate = (modelData) => {
  let returnFormat = "";
  if (modelData) {
    date.value = moment(modelData).format("yyyy-MM-DD");
  }
  emit1("update:modelValue", date.value);
  emit.emit("updateDateValue", 1);
};
const clearData = () => {
  emit1("update:modelValue", "");
};
</script>
<style>
.dp__month_year_wrap .dp__month_year_select {
  color: #fff !important;
}
.dp__btn .dp__inner_nav {
  color: #0000008d !important;
}
.dp__btn .dp__inner_nav:hover {
  color: #000 !important;
}
</style>

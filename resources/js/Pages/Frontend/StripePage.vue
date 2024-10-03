<template>
  <form id="payment-form">
    <div id="payment-element">
      <!-- Stripe will create form elements here -->
    </div>
    <button type="submit" @click="handleSubmit">Pay via Stripe</button>
  </form>
</template>

<script setup>
import { ref, onMounted } from "vue";

const token = ref(null);
const stripe = ref(null);
const elements = ref(null);
const PaymentIntent = ref(null);

onMounted(() => {
  axios
    .post("/payment/initiate", {
      amount: 150,
      currency: "USD",
    })
    .then((response) => {
      token.value = response.data.token; // Use to identify the payment
      stripe.value = Stripe(
        "pk_test_51PUlYXP0cyYM8ORhOOiof1YDwlzmX95cHYdaOhymtnVD88YIAxYL0rCYM9FdhMMdkcThlg5cdWqGu9d4AGDhRE3w00ei9maw0s"
      );
      const options = {
        clientSecret: response.data.client_secret,
      };
      elements.value = stripe.value.elements(options);
      const paymentElement = elements.value.create("payment");
      paymentElement.mount("#payment-element");
      PaymentIntent.value = response.data.paymentIntentId;
    })
    .catch((error) => {
      // throw error
    });
});

const handleSubmit = async (e) => {
  e.preventDefault();
  const { error } = await stripe.value.confirmPayment({
    elements: elements.value,
    redirect: "if_required",
  });

  if (error === undefined) {
    axios
      .post("/payment/complete", {
        token: token.value,
        paymentIntentId: PaymentIntent.value,
      })
      .then((response) => {
        console.log(response);
      });
  } else {
    axios.post("/payment/failure", {
      token: token.value,
      code: error.code,
      description: error.message,
    });
  }
};
</script>

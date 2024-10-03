<template lang="">
  <div>
    <div class="kt-portlet kt-portlet--mobile">
      <div class="kt-portlet__body">
        <form @submit.prevent="submit" enctype="multipart/form-data">
          <div class="form-group validated row" v-auto-animate>
            <div class="form-group col-lg-6">
              <label for="name">Name<span class="text-danger">*</span></label>
              <!-- <input type="text" id="name" class="form-control border-gray-200" placeholder="Enter Product Name"
                                v-model="form.name" @keypress="Createslug(form.name)"> -->
              <input
                type="text"
                id="name"
                class="form-control border-gray-200"
                placeholder="Enter Product Name"
                v-model="form.name"
                @keypress="Createslug(form.name)"
              />
              <span class="text-danger" v-if="form.errors.name">{{
                form.errors.name
              }}</span>
            </div>
            <div class="form-group col-lg-6">
              <label>Slug <span class="text-danger">*</span></label>
              <input
                type="text"
                id=""
                v-model="form.slug"
                class="form-control border-gray-200"
                placeholder="Enter Slug"
              />
              <!-- <input type="text" id="" v-model="slug" class="form-control border-gray-200"
                                placeholder="Enter Slug"> -->
              <span class="text-danger" v-if="form.errors.slug">{{
                form.errors.slug
              }}</span>
            </div>
            <div class="form-group col-lg-6">
              <label for="status"
                >Status <span class="text-danger">*</span></label
              >
              <select
                id="status"
                class="form-control border-gray-200"
                v-model="form.status"
              >
                <option value="">Select Status</option>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
              </select>
              <span class="text-danger" v-if="form.errors.status">{{
                form.errors.status
              }}</span>
            </div>

            <div class="form-group col-lg-6">
              <label for="file"
                >Thumbnail
                <span v-show="!product" class="text-danger">*</span></label
              >
              <file-upload
                @input="form.thumbnail = $event.target.files[0]"
                :imageurl="imageUrl"
              />
              <span class="text-danger" v-if="form.errors.thumbnail">{{
                form.errors.thumbnail
              }}</span>
            </div>

            <div class="form-group col-lg-6">
              <label for="file"
                >Available Stock <span class="text-danger">*</span></label
              >
              <input
                type="text"
                id="name"
                class="form-control border-gray-200"
                placeholder="Avalilable Stock"
                v-model="form.stock"
              />
              <span class="text-danger" v-if="form.errors.stock">{{
                form.errors.stock
              }}</span>
            </div>

            <div class="form-group col-lg-12">
              <label for=""
                >Description <span class="text-danger">*</span></label
              >
              <ckeditor v-model="form.description" :editor="editor"></ckeditor>
              <span class="text-danger" v-if="form.errors.description">{{
                form.errors.description
              }}</span>
            </div>
            <div class="form-group col-lg-12">
              <div class="row" v-for="(input, k) in form.product_attr" :key="k">
                <div class="form-group col-md-3">
                  <label for="include_title"
                    >Enter Size<span class="text-danger">*</span></label
                  >
                  <input
                    type="text"
                    v-model="input.size"
                    class="form-control border-gray-200"
                    placeholder="Enter Size"
                  />
                  <span
                    class="text-danger"
                    v-if="form.errors['product_attr.' + k + '.size']"
                    >{{ form.errors["product_attr." + k + ".size"] }}
                  </span>
                </div>
                <div class="form-group col-md-3">
                  <label for="quantity"
                    >Price<span class="text-danger">*</span></label
                  >
                  <input
                    type="text"
                    name=""
                    id=""
                    v-model="input.price"
                    class="form-control border-gray-200"
                    placeholder="Enter Price"
                  />
                  <span
                    class="text-danger"
                    v-if="form.errors['product_attr.' + k + '.price']"
                    >{{ form.errors["product_attr." + k + ".price"] }}
                  </span>
                </div>

                <div class="form-group col-md-4">
                  <label for="quantity"
                    >Description On Size<span class="text-danger"
                      >*</span
                    ></label
                  >
                  <textarea
                    name=""
                    col="20"
                    rows="5"
                    id=""
                    v-model="input.dtls"
                    class="form-control border-gray-200"
                    placeholder="Enter Description"
                  ></textarea>
                  <span
                    class="text-danger"
                    v-if="form.errors['product_attr.' + k + '.dtls']"
                    >{{ form.errors["product_attr." + k + ".dtls"] }}
                  </span>
                </div>

                <div class="col-md-2 mt-4">
                  <a
                    href="javascript:"
                    class="btn btn-primary m-2"
                    @click="addInput(k)"
                    v-show="k == form.product_attr.length - 1"
                    ><span>+</span>
                  </a>
                  <a
                    href="javascript:"
                    class="btn btn-primary"
                    @click="removeInput(k)"
                    v-show="k || (!k && form.product_attr.length > 1)"
                    ><span>-</span>
                  </a>
                </div>
              </div>

              <div class="row" v-for="(input, k) in form.product_shipping" :key="k">
                <div class="form-group col-md-5">
                  <label for="include_title"
                    >Enter Minimum Order<span class="text-danger">*</span></label
                  >
                  <input
                    type="text"
                    v-model="input.minimum_order"
                    class="form-control border-gray-200"
                    placeholder="Enter Minimum"
                  />
                  <span
                    class="text-danger"
                    v-if="form.errors['product_shipping.' + k + '.minimum_order']"
                    >{{ form.errors["product_shipping." + k + ".minimum_order"] }}
                  </span>
                </div>
                <div class="form-group col-md-5">
                  <label for="quantity"
                    >Price<span class="text-danger">*</span></label
                  >
                  <input
                    type="text"
                    name=""
                    id=""
                    v-model="input.price"
                    class="form-control border-gray-200"
                    placeholder="Enter Price"
                  />
                  <span
                    class="text-danger"
                    v-if="form.errors['product_shipping.' + k + '.price']"
                    >{{ form.errors["product_shipping." + k + ".price"] }}
                  </span>
                </div>

                

                <div class="col-md-2 mt-4">
                  <a
                    href="javascript:"
                    class="btn btn-primary m-2"
                    @click="addInputShipping(k)"
                    v-show="k == form.product_shipping.length - 1"
                    ><span>+</span>
                  </a>
                  <a
                    href="javascript:"
                    class="btn btn-primary"
                    @click="removeInputShipping(k)"
                    v-show="k || (!k && form.product_shipping.length > 1)"
                    ><span>-</span>
                  </a>
                </div>
              </div>
              <div class="row" v-for="(input, k) in form.faqs" :key="k">
                <div class="form-group col-md-5">
                  <label for="include_title"
                    >FAQ Question<span class="text-danger">*</span></label
                  >
                  <input
                    type="text"
                    v-model="input.question"
                    class="form-control border-gray-200"
                    placeholder="Enter Question"
                  />
                  <span
                    class="text-danger"
                    v-if="form.errors['faqs.' + k + '.question']"
                    >{{ form.errors["faqs." + k + ".question"] }}
                  </span>
                </div>
                <div class="form-group col-md-5">
                  <label for="quantity"
                    >FAQ Answer<span class="text-danger">*</span></label
                  >
                     <textarea
                    name=""
                    col="20"
                    rows="5"
                    id=""
                    v-model="input.answer"
                    class="form-control border-gray-200"
                    placeholder="Enter Answer"
                  ></textarea>
                  <span
                    class="text-danger"
                    v-if="form.errors['faqs.' + k + '.answer']"
                    >{{ form.errors["faqs." + k + ".answer"] }}
                  </span>
                </div>

                

                <div class="col-md-2 mt-4">
                  <a
                    href="javascript:"
                    class="btn btn-primary m-2"
                    @click="addInputFaq(k)"
                    v-show="k == form.faqs.length - 1"
                    ><span>+</span>
                  </a>
                  <a
                    href="javascript:"
                    class="btn btn-primary"
                    @click="removeInputFaq(k)"
                    v-show="k || (!k && form.faqs.length > 1)"
                    ><span>-</span>
                  </a>
                </div>
              </div>
            </div>

            <div class="form-group validated row"></div>

            <div class="form-group validated row">
              <div class="form-group col-lg-12 mt-5 seo-edit newAdSeo_settings">
                <h4>Seo Settings:</h4>
              </div>
              <div class="form-group col-lg-6">
                <label>H1 </label>
                <input
                  type="text"
                  id=""
                  v-model="form.h1"
                  class="form-control border-gray-200"
                  placeholder="Heading"
                />
                <span class="text-danger" v-if="form.errors.h1">{{
                  form.errors.h1
                }}</span>
              </div>
              <div class="form-group col-lg-6">
                <label>Meta Title </label>
                <input
                  type="text"
                  id=""
                  v-model="form.meta_title"
                  class="form-control border-gray-200"
                  placeholder="Enter Meta Title"
                />
                <span class="text-danger" v-if="form.errors.meta_title">{{
                  form.errors.meta_title
                }}</span>
              </div>
              <div class="form-group col-lg-6">
                <label>Meta Title </label>
                <input
                  type="text"
                  id=""
                  v-model="form.meta_title"
                  class="form-control border-gray-200"
                  placeholder="Enter Meta Title"
                />
                <span class="text-danger" v-if="form.errors.meta_title">{{
                  form.errors.meta_title
                }}</span>
              </div>
              <div class="form-group col-lg-6">
                <label for="category_id">Meta Description </label>
                <textarea
                  name=""
                  id=""
                  class="form-control border-gray-200"
                  v-model="form.meta_description"
                  placeholder="Enter Meta Description"
                  rows="5"
                ></textarea>
                <span class="text-danger" v-if="form.errors.meta_description">{{
                  form.errors.meta_description
                }}</span>
              </div>
              <div class="form-group col-lg-6">
                <label for="file">Featured Image </label>
                <file-upload
                  @input="form.featured_image = $event.target.files[0]"
                  :imageurl="featuredimgUrl"
                />
                <span class="text-danger" v-if="form.errors.featured_image">{{
                  form.errors.featured_image
                }}</span>
              </div>
              <div class="form-group col-lg-6">
                <label>Open Graph Title </label>
                <input
                  type="text"
                  id=""
                  v-model="form.open_graph_title"
                  class="form-control border-gray-200"
                  placeholder="Enter Open Graph Title"
                />
                <span class="text-danger" v-if="form.errors.open_graph_title">{{
                  form.errors.open_graph_title
                }}</span>
              </div>
              <div class="form-group col-lg-6">
                <label for="category_id">Open Graph Description </label>
                <textarea
                  name=""
                  id=""
                  class="form-control border-gray-200"
                  placeholder="Open Graph Description"
                  rows="5"
                  v-model="form.open_graph_description"
                ></textarea>
                <span
                  class="text-danger"
                  v-if="form.errors.open_graph_description"
                  >{{ form.errors.open_graph_description }}</span
                >
              </div>

              <div class="form-group col-lg-6">
                <label for="open_graph_url">Open Graph Url</label>
                <input
                  type="text"
                  id="open_graph_url"
                  v-model="form.open_graph_url"
                  class="form-control border-gray-200"
                  placeholder="Open Graph Url"
                />
                <span class="text-danger" v-if="form.errors.open_graph_url">{{
                  form.errors.open_graph_url
                }}</span>
              </div>

              <div class="form-group col-lg-6">
                <label for="file">OG image + X large summary card</label>
                <file-upload
                  @input="form.open_graph_image = $event.target.files[0]"
                  :imageurl="seoimageUrl"
                />
                <span class="text-danger" v-if="form.errors.open_graph_image">{{
                  form.errors.open_graph_image
                }}</span>
              </div>

              <div class="form-group col-lg-6">
                <label for="category_id">X Card Title </label>
                <input
                  type="text"
                  id=""
                  v-model="form.x_card_title"
                  class="form-control border-gray-200"
                  placeholder="Enter X Card Title"
                />
                <span class="text-danger" v-if="form.errors.x_card_title">{{
                  form.errors.x_card_title
                }}</span>
              </div>

              <div class="form-group col-lg-6">
                <label>X Card Description </label>
                <textarea
                  name=""
                  id=""
                  class="form-control border-gray-200"
                  placeholder="X Card Description"
                  v-model="form.x_card_description"
                  rows="5"
                ></textarea>

                <span
                  class="text-danger"
                  v-if="form.errors.x_card_description"
                  >{{ form.errors.x_card_description }}</span
                >
              </div>
            </div>

            <!-- <div class="form-group col-lg-6">
                            <label>Canonical Url </label>
                            <input type="text" id="" v-model="form.canonical_url" class="form-control border-gray-200"
                                placeholder="Enter Canonical Url">
                            <span class="text-danger" v-if="form.errors.canonical_url">{{ form.errors.canonical_url
                                }}</span>
                        </div> -->

            <div class="kt-portlet__foot col col-12">
              <div class="kt-form__actions">
                <div class="row">
                  <div class="pr-2">
                    <submit-button
                      :disabled="form.processing"
                      :isLoading="form.processing"
                      >Submit</submit-button
                    >
                  </div>
                  <div>
                    <Link
                      :href="route('admin.product.list')"
                      class="btn btn-secondary"
                      >Cancel
                    </Link>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, onUpdated, reactive, ref } from "vue";
import { useForm, router } from "@inertiajs/vue3";
import FileUpload from "../../../components/FileUpload.vue";
import SubmitButton from "../../../components/SubmitButton.vue";
import { component as ckeditor } from "@mayasabha/ckeditor4-vue3";

const props = defineProps({
  errors: Object,
  product: Object,
  product_attributes: Object,
  product_shippings: Object,
  faqs: Object,
});
const form = useForm({
  name: props.product?.name || null,
  description: props.product?.description || null,
  thumbnail: props.product?.thumbnail || null,
  status: props.product?.status || "",
  stock: props.product?.available_stock || "",
  product_attr: [
    {
      size: "",
      dtls: "",
      price: "",
    },
  ],
  product_shipping: [
    {
      minimum_order: "",
      price: "",
    },
  ],
  faqs: [
    {
      question: "",
      answer: "",
    },
  ],
  slug: props.product?.slug || null,
  h1: props.product?.h1 || null,
  meta_title: props.product?.meta_title || null,
  meta_description: props.product?.meta_description || null,
  open_graph_title: props.product?.open_graph_title || null,
  open_graph_description: props.product?.open_graph_description || null,
  open_graph_image: props.product?.open_graph_image || null,
  open_graph_url: props.product?.open_graph_url || null,
  featured_image: props.product?.featured_image || null,
  x_card_title: props.product?.x_card_title || null,
  x_card_description: props.product?.x_card_description || null,
  // canonical_url: props.product?.canonical_url || null,
});

//add & remove ingredient select box start
const addInput = async () => {
  form.product_attr.push({
    size: "",
    dtls: "",
    price: "",
  });
};
const removeInput = async (index) => {
  form.product_attr.splice(index, 1);
};
const addInputShipping = async () => {
  form.product_shipping.push({
    minimum_order: "",
    price: "",
  });
};
const removeInputShipping = async (index) => {
  form.product_shipping.splice(index, 1);
};


const addInputFaq = async () => {
  form.faqs.push({
    question: "",
    answer: "",
  });
};
const removeInputFaq = async (index) => {
  form.faqs.splice(index, 1);
};
//add & remove ingredient select box end

// onUpdated(() => {
//   emit.emit("fileuploadmessage", props.errors.thumbnail);
// });

const imageUrl = ref("");
const seoimageUrl = ref("");
const featuredimgUrl = ref("");

onMounted(() => {
  imageUrl.value = props.product?.product_image_url || "";
  seoimageUrl.value = props.product?.open_graph_image_url || "";
  featuredimgUrl.value = props.product?.featured_image_url || "";
  if (props.product) {
    form.product_attr = [];
    if (props.product_attributes.length > 0) {
      for (let index = 0; index < props.product_attributes.length; index++) {
        form.product_attr.push({
          size: props.product_attributes[index].size,
          dtls: props.product_attributes[index].details,
          price: props.product_attributes[index].price,
        });
      }
    } else {
      form.product_attr.push({
        size: "",
        dtls: "",
        price: "",
      });
    }
    form.product_shipping = [];
    if (props.product_shippings.length > 0) {
      for (let index = 0; index < props.product_shippings.length; index++) {
        form.product_shipping.push({
          minimum_order: props.product_shippings[index].minimum_order,
          price: props.product_shippings[index].price,
        });
      }
    } else {
      form.product_shipping.push({
        minimum_order: "",
        price: "",
      });
    }

      form.faqs = [];
    if (props.faqs.length > 0) {
      for (let index = 0; index < props.faqs.length; index++) {
        form.faqs.push({
          question: props.faqs[index].question,
          answer: props.faqs[index].answer,
        });
      }
    } else {
      form.faqs.push({
        question: "",
        question: "",
      });
    }

    emit.emit("pageName", "Product Management", [
      {
        title: "Product List",
        routeName: "admin.product.list",
      },
      {
        title: "Edit Product",
        routeName: "",
      },
    ]);
  } else {
    emit.emit("pageName", "Product Management", [
      {
        title: "Product List",
        routeName: "admin.product.list",
      },
      {
        title: "Add New Product",
        routeName: "",
      },
    ]);
  }
});

let slug = ref("");
function Createslug(pagename) {
  slug = form.name.toLowerCase().replace(/\s+/g, "-");
  return slug;
}

async function submit() {
  try {
    if (props.product) {
      await form.post(route("admin.editProduct", props.product.id));
    } else {
      await form.post(route("admin.product.create"));
    }
  } catch (error) {
    if (error.response && error.response.status === 422) {
      form.errors = error.response.data.errors;
    }
  }
}
</script>

<style>
.ck-editor__editable {
  min-height: 200px;
}
.seo-edit {
  margin-bottom: 15px;
  border-bottom: 1px solid #d7d8db;
}
</style>

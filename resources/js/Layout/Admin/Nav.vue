<template lang="">
  <button
    class="kt-aside-close"
    v-if="mobileMenuHideShow"
    @click="mobileMenuHideShow = !mobileMenuHideShow"
    id="kt_aside_close_btn"
  >
    <i class="la la-close"></i>
  </button>
  <div
    class="kt-aside dashboard_sidebar kt-aside--fixed kt-grid__item kt-grid kt-grid--desktop kt-grid--hor-desktop"
    :class="{ 'kt-aside--on': mobileMenuHideShow }"
    id="kt_aside"
  >
    <div class="kt-aside__brand kt-grid__item" id="kt_aside_brand">
      <div class="kt-aside__brand-logo">
        <Link :href="route('admin.dashboard')" class="logo_text_custom">
          <img
            :src="'/admin_assets/emory.png'"
            alt=""
            style="height: 31px; width: 148px; margin-top: 17px"
          />
        </Link>
      </div>
      <div class="kt-aside__brand-tools">
        <button
          class="kt-aside__brand-aside-toggler"
          id="kt_aside_toggler"
          @click="toggleSideMenu"
        >
          <span>
            <svg
              xmlns="http://www.w3.org/2000/svg"
              version="1.1"
              xmlns:xlink="http://www.w3.org/1999/xlink"
              width="512"
              height="512"
              x="0"
              y="0"
              viewBox="0 0 24 24"
              style="enable-background: new 0 0 512 512"
              xml:space="preserve"
              class=""
            >
              <g>
                <g fill="#000">
                  <path
                    d="M20 7H4c-.6 0-1-.4-1-1s.4-1 1-1h16c.6 0 1 .4 1 1s-.4 1-1 1zM14 13H4c-.6 0-1-.4-1-1s.4-1 1-1h10c.6 0 1 .4 1 1s-.4 1-1 1zM18 19H4c-.6 0-1-.4-1-1s.4-1 1-1h14c.6 0 1 .4 1 1s-.4 1-1 1z"
                    fill="#000000"
                    opacity="1"
                    data-original="#000000"
                  ></path>
                </g>
              </g>
            </svg>
          </span>
          <span>
            <svg
              xmlns="http://www.w3.org/2000/svg"
              xmlns:xlink="http://www.w3.org/1999/xlink"
              width="24px"
              height="24px"
              viewBox="0 0 24 24"
              version="1.1"
              class="kt-svg-icon"
            >
              <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <polygon id="Shape" points="0 0 24 0 24 24 0 24" />
                <path
                  d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z"
                  id="Path-94"
                  fill="#000000"
                  fill-rule="nonzero"
                />
                <path
                  d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z"
                  id="Path-94"
                  fill="#000000"
                  fill-rule="nonzero"
                  opacity="0.3"
                  transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) "
                />
              </g>
            </svg>
          </span>
        </button>
      </div>
    </div>
    <perfect-scrollbar>
      <div
        class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid main-sidebar"
        id="kt_aside_menu_wrapper"
      >
        <div
          id="kt_aside_menu"
          class="kt-aside-menu"
          data-ktmenu-vertical="1"
          data-ktmenu-scroll="1"
          data-ktmenu-dropdown-timeout="500"
        >
          <ul class="kt-menu__nav">
            <li class="kt-menu__section ">
              <div v-if="!isEditor" class="side-menu-hdr">
                <ul class="menuNewAll"  >
                  <li class="kt-menu__item active" aria-haspopup="true">
                    <span class="kt-menu__link">
                      <Icon
                        icon="bx:home"
                        color="white"
                        width="18"
                        height="18"
                        class="kt-menu__link-icon mr-3"
                      />
                      <span class="kt-menu__link-text"
                        >Dashboard<i class="menuDropdwnIcon"
                          ><img :src="'/admin_assets/blue-arrow-down.svg'" /></i
                      ></span>
                      
                    </span>
                  </li>
                  <ul class="subMenu_new">
                    <li
                      :class="{
                        active: $page.component.startsWith('Admin/Dashboard'),
                      }"
                    >
                      <Link href="/admin/dashboard"
                        ><span class="kmenuLinkText">Traffic</span></Link
                      >
                    </li>
                    <li
                      :class="{
                        active: $page.component.startsWith('Admin/Sales'),
                      }"
                    >
                      <Link href="/admin/sales">
                        <span class="kmenuLinkText">Sales</span>
                      </Link>
                    </li>
                  </ul>
                </ul>
              </div>
              <div v-else class="side-menu-hdr" style="cursor: not-allowed; pointer-events: none">
                <ul class="menuNewAll"  >
                  <li class="kt-menu__item active" aria-haspopup="true">
                    <span class="kt-menu__link">
                      <Icon
                        icon="bx:home"
                        color="white"
                        width="18"
                        height="18"
                        class="kt-menu__link-icon mr-3"
                      />
                      <span v-if="!isEditor" class="kt-menu__link-text"
                        >Dashboard<i class="menuDropdwnIcon"
                          ><img :src="'/admin_assets/blue-arrow-down.svg'" /></i
                      ></span>
                      <span
                        v-else
                        class="kt-menu__link-text"
                        style="color: gray"
                        >Dashboard<i class="menuDropdwnIcon"
                          ><img :src="'/admin_assets/blue-arrow-down.svg'" /></i
                      ></span>
                    </span>
                  </li>
                  
                </ul>
              </div>
            </li>
            <li class="kt-menu__section active">
              <div class="side-menu-hdr">
                <ul class="menuNewAll">
                  <li class="kt-menu__item" aria-haspopup="true">
                    <span class="kt-menu__link">
                      <Icon
                        icon="clarity:resource-pool-solid"
                        color="white"
                        width="18"
                        height="18"
                        class="kt-menu__link-icon mr-3"
                      />
                      <span class="kt-menu__link-text"
                        >Resources<i class="menuDropdwnIcon"
                          ><img :src="'/admin_assets/blue-arrow-down.svg'" /></i
                      ></span>
                    </span>
                  </li>
                  <ul class="subMenu_new">
                    <li
                      :class="{
                        active: $page.component.startsWith(
                          'Admin/resource/List'
                        ),
                      }"
                    >
                      <Link href="/admin/resource-list"
                        ><span class="kmenuLinkText">All Posts</span></Link
                      >
                    </li>
                    <li
                      :class="{
                        active: $page.component.startsWith(
                          'Admin/resource/CreateEdit'
                        ),
                      }"
                    >
                      <Link href="/admin/resource-create"
                        ><span class="kmenuLinkText">Add New Post</span></Link
                      >
                    </li>
                  </ul>
                </ul>
              </div>
            </li>
            <!-- <li class="kt-menu__section active">
              <div class="side-menu-hdr">
                <ul class="menuNewAll">
                  <li class="kt-menu__item" aria-haspopup="true">
                    <span class="kt-menu__link">
                      <Icon
                        icon="fluent:content-view-20-regular"
                        color="white"
                        width="20"
                        height="20"
                        class="kt-menu__link-icon mr-3"
                      />
                      <span class="kt-menu__link-text"
                        >Pages<i class="menuDropdwnIcon"
                          ><img :src="'/admin_assets/blue-arrow-down.svg'" /></i
                      ></span>
                    </span>
                  </li>
                  <ul class="subMenu_new">
                    <li
                      :class="{
                        active: $page.component.startsWith('Admin/cms/List'),
                      }"
                    >
                      <Link href="/admin/cms"
                        ><span class="kmenuLinkText">All Pages</span></Link
                      >
                    </li>
                    <li
                      :class="{
                        active:
                          $page.component.startsWith('Admin/cms/CmsNewPages') ||
                          $page.component.startsWith('Admin/cms/CmsPageEdit'),
                      }"
                    >
                      <Link href="/admin/cms-new-page"
                        ><span class="kmenuLinkText">Add New Page</span></Link
                      >
                    </li>
                  </ul>
                </ul>
              </div>
            </li> -->
            <li class="kt-menu__section active">
              <div class="side-menu-hdr">
                <ul class="menuNewAll">
                  <li class="kt-menu__item" aria-haspopup="true">
                    <span class="kt-menu__link">
                      <Icon
                        icon="fluent:content-view-20-regular"
                        color="white"
                        width="20"
                        height="20"
                        class="kt-menu__link-icon mr-3"
                      />
                      <span class="kt-menu__link-text"
                        >SEO Pages<i class="menuDropdwnIcon"
                          ><img :src="'/admin_assets/blue-arrow-down.svg'" /></i
                      ></span>
                    </span>
                  </li>
                  <ul class="subMenu_new">
                    <li
                      :class="{
                        active: $page.component.startsWith('Admin/seo/List'),
                      }"
                    >
                      <Link href="/admin/seo-pages"
                        ><span class="kmenuLinkText">All SEO Pages</span></Link
                      >
                    </li>
                    <li
                      :class="{
                        active:
                          $page.component.startsWith('Admin/seo/NewPages') ||
                          $page.component.startsWith('Admin/seo/PageEdit'),
                      }"
                    >
                      <Link href="/admin/seo-page-create"
                        ><span class="kmenuLinkText"
                          >Add New SEO Page</span
                        ></Link
                      >
                    </li>
                  </ul>
                </ul>
              </div>
            </li>
            <li class="kt-menu__section active">
              <div class="side-menu-hdr">
                <ul class="menuNewAll">
                  <li class="kt-menu__item" aria-haspopup="true">
                    <span class="kt-menu__link">
                      <Icon
                        icon="fluent:content-view-20-regular"
                        color="white"
                        width="20"
                        height="20"
                        class="kt-menu__link-icon mr-3"
                      />
                      <span class="kt-menu__link-text"
                        >Distributions<i class="menuDropdwnIcon"
                          ><img :src="'/admin_assets/blue-arrow-down.svg'" /></i
                      ></span>
                    </span>
                  </li>
                  <ul class="subMenu_new">
                    <li
                      :class="{
                        active: $page.component.startsWith(
                          'Admin/distribution/List'
                        ),
                      }"
                    >
                      <Link href="/admin/distribution-center"
                        ><span class="kmenuLinkText"
                          >All Distributions</span
                        ></Link
                      >
                    </li>
                    <li
                      :class="{
                        active:
                          $page.component.startsWith(
                            'Admin/distribution/NewPages'
                          ) ||
                          $page.component.startsWith(
                            'Admin/distribution/PageEdit'
                          ),
                      }"
                    >
                      <Link href="/admin/distribution-create"
                        ><span class="kmenuLinkText"
                          >Add New Distribution</span
                        ></Link
                      >
                    </li>
                  </ul>
                </ul>
              </div>
            </li>
            <li class="kt-menu__section active">
              <div class="side-menu-hdr">
                <ul class="menuNewAll">
                  <li class="kt-menu__item" aria-haspopup="true">
                    <span class="kt-menu__link" preserve-scroll>
                      <Icon
                        icon="fluent-mdl2:product"
                        color="white"
                        width="22"
                        height="22"
                        class="kt-menu__link-icon mr-3"
                      />
                      <span class="kt-menu__link-text"
                        >Products<i class="menuDropdwnIcon"
                          ><img :src="'/admin_assets/blue-arrow-down.svg'" /></i
                      ></span>
                    </span>
                  </li>
                  <ul class="subMenu_new">
                    <li
                      :class="{
                        active: $page.component.startsWith(
                          'Admin/product/ProductList'
                        ),
                      }"
                    >
                      <Link href="/admin/product-list"
                        ><span class="kmenuLinkText">All Products</span></Link
                      >
                    </li>
                    <li
                      :class="{
                        active: $page.component.startsWith(
                          'Admin/product/CreateEdit'
                        ),
                      }"
                    >
                      <Link href="/admin/product-create"
                        ><span class="kmenuLinkText"
                          >Add New Product</span
                        ></Link
                      >
                    </li>
                    <li
                      :class="{
                        active: $page.component.startsWith(
                          'Admin/product/CustomCutDryice'
                        ),
                      }"
                    >
                      <Link href="/admin/custom-cut-dryice-list"
                        ><span class="kmenuLinkText"
                          >Custom cut dryice</span
                        ></Link
                      >
                    </li>
                  </ul>
                </ul>
              </div>
            </li>

            <li class="kt-menu__section active">
              <div class="side-menu-hdr">
                <ul class="menuNewAll">
                  <li class="kt-menu__item" aria-haspopup="true">
                    <span class="kt-menu__link" preserve-scroll>
                      <Icon
                        icon="fluent-mdl2:product"
                        color="white"
                        width="22"
                        height="22"
                        class="kt-menu__link-icon mr-3"
                      />
                      <span class="kt-menu__link-text"
                        >Dry Ice By City<i class="menuDropdwnIcon"
                          ><img :src="'/admin_assets/blue-arrow-down.svg'" /></i
                      ></span>
                    </span>
                  </li>
                  <ul class="subMenu_new">
                    <li
                      :class="{
                        active: $page.component.startsWith(
                          'Admin/dry_ice/DryIceList'
                        ),
                      }"
                    >
                      <Link href="/admin/dry-ice-list"
                        ><span class="kmenuLinkText"
                          >All Dry Ice by city</span
                        ></Link
                      >
                    </li>
                    <li
                      :class="{
                        active: $page.component.startsWith(
                          'Admin/dry_ice/CreateEdit'
                        ),
                      }"
                    >
                      <Link href="/admin/dry-ice-create"
                        ><span class="kmenuLinkText">Add New</span></Link
                      >
                    </li>
                  </ul>
                </ul>
              </div>
            </li>

            <!-- <li class="kt-menu__section active">
              <div class="side-menu-hdr">
                <ul class="menuNewAll">
                  <li class="kt-menu__item" aria-haspopup="true">
                    <span class="kt-menu__link">
                      <Icon
                        icon="carbon:review"
                        color="white"
                        width="18"
                        height="18"
                        class="kt-menu__link-icon mr-3"
                      />
                      <span class="kt-menu__link-text"
                        >Reviews<i class="menuDropdwnIcon"
                          ><img :src="'/admin_assets/blue-arrow-down.svg'" /></i
                      ></span>
                    </span>
                  </li>
                  <ul class="subMenu_new">
                    <li
                      :class="{
                        active: $page.component.startsWith(
                          'Admin/testimonial/List'
                        ),
                      }"
                    >
                      <Link href="/admin/testimonial"
                        ><span class="kmenuLinkText">All Reviews</span></Link
                      >
                    </li>
                    <li
                      :class="{
                        active: $page.component.startsWith(
                          'Admin/testimonial/CreateEdit'
                        ),
                      }"
                    >
                      <Link href="/admin/testimonial-create"
                        ><span class="kmenuLinkText">Add Review</span></Link
                      >
                    </li>
                  </ul>
                </ul>
              </div>
            </li> -->
            <!-- <li class="kt-menu__section active">
                                <div class="side-menu-hdr">
                                    <ul class="menuNewAll">
                                        <li class="kt-menu__item " :class="{ 'kt-menu__item--active': $page.component.startsWith('Admin/user') }" aria-haspopup="true">
                                            <Link>
                                                <Icon icon="fa-solid:users" color="white" width="15" height="15" class="kt-menu__link-icon mr-3" />
                                            <span class="kt-menu__link-text">Customers</span>
                                            </Link>
                                        </li>
                                        <ul class="subMenu_new">
                                            <li>
                                                <Link><span class="kmenuLinkText">All Customers</span></Link>
                                            </li>
                                            <li>
                                                <Link><span class="kmenuLinkText">Add New Customer</span></Link>
                                            </li>
                                        </ul>
                                    </ul>
                                </div>
                            </li> -->
            <li class="kt-menu__section active">
              <div v-if="!isEditor" class="side-menu-hdr">
                <ul class="menuNewAll">
                  <li class="kt-menu__item" aria-haspopup="true">
                    <span class="kt-menu__link">
                      <Icon
                        icon="fa-solid:users"
                        color="white"
                        width="15"
                        height="15"
                        class="kt-menu__link-icon mr-3"
                      />
                      <span class="kt-menu__link-text"
                        >Users<i class="menuDropdwnIcon"
                          ><img :src="'/admin_assets/blue-arrow-down.svg'" /></i
                      ></span>
                      
                    </span>
                  </li>
                  <ul class="subMenu_new">
                    <li
                      :class="{
                        active: $page.component.startsWith('Admin/user/List'),
                      }"
                    >
                      <Link :href="route('admin.users')"
                        ><span class="kmenuLinkText">All Users</span></Link
                      >
                    </li>
                    
                    <li
                      :class="{
                        active: $page.component.startsWith(
                          'Admin/user/CreateEdit'
                        ),
                      }"
                    >
                      <Link href="/admin/create-user"
                        ><span class="kmenuLinkText">Add New User</span></Link
                      >
                    </li>
                  </ul>
                </ul>
              </div>
              <div v-else class="side-menu-hdr" style="cursor: not-allowed; pointer-events: none">
                <ul class="menuNewAll">
                  <li class="kt-menu__item" aria-haspopup="true">
                    <span class="kt-menu__link">
                      <Icon
                        icon="fa-solid:users"
                        color="white"
                        width="15"
                        height="15"
                        class="kt-menu__link-icon mr-3"
                      />
                      <!-- <span v-if="!isEditor" class="kt-menu__link-text"
                        >Dashboard<i class="menuDropdwnIcon"
                          ><img :src="'/admin_assets/blue-arrow-down.svg'" /></i
                      ></span>
                      <span
                        v-else
                        class="kt-menu__link-text"
                        style="color: gray"
                        >Dashboard<i class="menuDropdwnIcon"
                          ><img :src="'/admin_assets/blue-arrow-down.svg'" /></i
                      ></span> -->
                      <span class="kt-menu__link-text"
                       style="color: gray"
                        >Users<i class="menuDropdwnIcon"
                          ><img :src="'/admin_assets/blue-arrow-down.svg'" /></i
                      ></span>
                      
                    </span>
                  </li>
                </ul>
              </div>
            </li>
            <li class="kt-menu__section active">
              <div class="side-menu-hdr">
                <ul class="menuNewAll">
                  <li class="kt-menu__item" aria-haspopup="true">
                    <span class="kt-menu__link">
                      <Icon
                        icon="streamline:industry-innovation-and-infrastructure-solid"
                        color="white"
                        width="18"
                        height="18"
                        class="kt-menu__link-icon mr-3"
                      />
                      <span class="kt-menu__link-text"
                        >Industry<i class="menuDropdwnIcon"
                          ><img :src="'/admin_assets/blue-arrow-down.svg'" /></i
                      ></span>
                    </span>
                  </li>
                  <ul class="subMenu_new">
                    <li
                      :class="{
                        active: $page.component.startsWith(
                          'Admin/Industry/List'
                        ),
                      }"
                    >
                      <Link href="/admin/industry"
                        ><span class="kmenuLinkText">All Industry</span></Link
                      >
                    </li>
                    <li
                      :class="{
                        active: $page.component.startsWith(
                          'Admin/Industry/CreateEdit'
                        ),
                      }"
                    >
                      <Link href="/admin/industry-create"
                        ><span class="kmenuLinkText"
                          >Add New Industry</span
                        ></Link
                      >
                    </li>
                  </ul>
                </ul>
              </div>
            </li>
            <li class="kt-menu__section active">
              <div v-if="!isEditor" class="side-menu-hdr">
                <ul class="menuNewAll">
                  <li class="kt-menu__item" aria-haspopup="true">
                    <span class="kt-menu__link">
                      <Icon
                        icon="bxs:select-multiple"
                        color="white"
                        width="18"
                        height="18"
                        class="kt-menu__link-icon mr-3"
                      />
                      <span class="kt-menu__link-text"
                        >Choose For<i class="menuDropdwnIcon"
                          ><img :src="'/admin_assets/blue-arrow-down.svg'" /></i
                      ></span>
                      
                    </span>
                  </li>
                  <ul class="subMenu_new">
                    <li
                      :class="{
                        active: $page.component.startsWith(
                          'Admin/choose_for/List'
                        ),
                      }"
                    >
                      <Link href="/admin/choose-for-list"
                        ><span class="kmenuLinkText">All Choose</span></Link
                      >
                    </li>
                  
                    <li
                      :class="{
                        active: $page.component.startsWith(
                          'Admin/choose_for/CreateEdit'
                        ),
                      }"
                    >
                      <Link href="/admin/create-choose-for"
                        ><span class="kmenuLinkText">Add New Choose</span></Link
                      >
                    </li>
                   
                  </ul>
                </ul>
              </div>
              <div v-else class="side-menu-hdr" style="cursor: not-allowed; pointer-events: none">
                <ul class="menuNewAll">
                  <li class="kt-menu__item" aria-haspopup="true">
                    <span class="kt-menu__link">
                      <Icon
                        icon="bxs:select-multiple"
                        color="white"
                        width="18"
                        height="18"
                        class="kt-menu__link-icon mr-3"
                      />
                     
                      <span
                        class="kt-menu__link-text"
                        style="color: gray"
                        >Choose For<i class="menuDropdwnIcon"
                          ><img :src="'/admin_assets/blue-arrow-down.svg'" /></i
                      ></span>
                    </span>
                  </li>
                  
                </ul>
              </div>
            </li>
            <li class="kt-menu__section active">
              <div class="side-menu-hdr">
                <ul class="menuNewAll">
                  <li class="kt-menu__item" aria-haspopup="true">
                    <span class="kt-menu__link" preserve-scroll>
                      <Icon
                        icon="wpf:faq"
                        color="white"
                        width="20"
                        height="20"
                        class="kt-menu__link-icon mr-3"
                      />
                      <span class="kt-menu__link-text"
                        >FAQ<i class="menuDropdwnIcon"
                          ><img :src="'/admin_assets/blue-arrow-down.svg'" /></i
                      ></span>
                    </span>
                  </li>
                  <ul class="subMenu_new">
                    <li
                      :class="{
                        active: $page.component.startsWith('Admin/faq/List'),
                      }"
                    >
                      <Link href="/admin/faq"
                        ><span class="kmenuLinkText">All FAQ</span></Link
                      >
                    </li>
                    <li
                      :class="{
                        active: $page.component.startsWith(
                          'Admin/faq/CreateEdit'
                        ),
                      }"
                    >
                      <Link href="/admin/faq/create"
                        ><span class="kmenuLinkText">Add New FAQ</span></Link
                      >
                    </li>
                  </ul>
                </ul>
              </div>
            </li>
            <li class="kt-menu__section active">
              <div class="side-menu-hdr subMenu_new2">
                <ul class="menuNewAll">
                  <li
                    v-if="!isEditor"
                    class="kt-menu__item"
                    :class="{
                      'kt-menu__item--active':
                        $page.component.startsWith('Admin/Order'),
                    }"
                    aria-haspopup="true"
                  >
                    <Link
                      :href="route('admin.orders')"
                      class="kt-menu__link"
                      preserve-scroll
                    >
                      <Icon
                        icon="streamline:industry-innovation-and-infrastructure-solid"
                        color="white"
                        width="20"
                        height="20"
                        class="kt-menu__link-icon mr-3"
                      />
                      <span class="kt-menu__link-text">Order</span>
                    </Link>
                  </li>
                  <li v-else class="disabled" >
                    <Link
                      class="kt-menu__link"
                      preserve-scroll
                      style="cursor: not-allowed; pointer-events: none"
                    >
                      <Icon
                        icon="streamline:industry-innovation-and-infrastructure-solid"
                        color="white"
                        width="20"
                        height="20"
                        class="kt-menu__link-icon mr-3"
                      />
                      <span class="kt-menu__link-text" style="color: gray"
                        >Order</span
                      >
                    </Link>
                  </li>
                </ul>
              </div>
            </li>
            <li  class="kt-menu__section active">
              <div class="side-menu-hdr subMenu_new2">
                <ul class="menuNewAll">
                  <li
                    v-if="!isEditor"
                    class="kt-menu__item"
                    :class="{
                      'kt-menu__item--active':
                        $page.component.startsWith('Admin/ContactUs'),
                    }"
                    aria-haspopup="true"
                  >
                    <Link
                      :href="route('admin.contact-us')"
                      class="kt-menu__link"
                      preserve-scroll
                    >
                      <Icon
                        icon="wpf:faq"
                        color="white"
                        width="20"
                        height="20"
                        class="kt-menu__link-icon mr-3"
                      />
                      <span class="kt-menu__link-text">Contact Us</span>
                    </Link>
                  </li>
                  <li v-else class="disabled">
                    <Link
                      class="kt-menu__link"
                      preserve-scroll
                      style="cursor: not-allowed; pointer-events: none"
                    >
                      <Icon
                        icon="wpf:faq"
                        color="white"
                        width="20"
                        height="20"
                        class="kt-menu__link-icon mr-3"
                      />
                      <span class="kt-menu__link-text" style="color: gray"
                        >Contact Us</span
                      >
                    </Link>
                  </li>
                </ul>
              </div>
              
            </li>
            
            <li class="kt-menu__section active">
              <div class="side-menu-hdr subMenu_new2">
                <ul class="menuNewAll">
                  <li
                    v-if="!isEditor"
                    class="kt-menu__item"
                    :class="{
                      'kt-menu__item--active': $page.component.startsWith(
                        'Admin/FooterSettings'
                      ),
                    }"
                    aria-haspopup="true"
                  >
                    <Link
                      :href="route('admin.footer-settings')"
                      class="kt-menu__link"
                      preserve-scroll
                    >
                      <Icon
                        icon="wpf:faq"
                        color="white"
                        width="20"
                        height="20"
                        class="kt-menu__link-icon mr-3"
                      />
                      <span class="kt-menu__link-text">Footer Settings</span>
                    </Link>
                  </li>
                  <li v-else class="disabled">
                    <Link
                      class="kt-menu__link"
                      preserve-scroll
                      style="cursor: not-allowed; pointer-events: none"
                    >
                      <Icon
                        icon="wpf:faq"
                        color="white"
                        width="20"
                        height="20"
                        class="kt-menu__link-icon mr-3"
                      />
                      <span class="kt-menu__link-text" style="color: gray"
                        >Footer Settings</span
                      >
                    </Link>
                  </li>
                </ul>
              </div>
            </li>
            <li class="kt-menu__section active">
              <div class="side-menu-hdr subMenu_new2">
                <ul class="menuNewAll">
                  <li
                    class="kt-menu__item"
                    :class="{
                      'kt-menu__item--active':
                        $page.component.startsWith('Admin/AdminProfile'),
                    }"
                    aria-haspopup="true"
                  >
                    <Link
                      :href="route('admin.profile')"
                      class="kt-menu__link"
                      preserve-scroll
                    >
                      <Icon
                        icon="wpf:faq"
                        color="white"
                        width="20"
                        height="20"
                        class="kt-menu__link-icon mr-3"
                      />
                      <span class="kt-menu__link-text">Settings</span>
                    </Link>
                  </li>
                </ul>
              </div>
            </li>
            <li class="kt-menu__section active">
              <div class="side-menu-hdr">
                <ul class="menuNewAll subMenu_new2">
                  <li class="kt-menu__item" aria-haspopup="true">
                    <Link
                      :href="route('admin.logout')"
                      class="kt-menu__link"
                      preserve-scroll
                      method="post"
                      style="margin-top: 8px"
                    >
                      <Icon
                        icon="ri:logout-box-r-line"
                        width="20"
                        height="20"
                        class="kt-menu__link-icon mr-3"
                      />
                      <span class="kt-menu__link-text">Log Out</span>
                    </Link>
                  </li>
                </ul>
              </div>
            </li>
            <!-- MAIN -->
          </ul>
        </div>
      </div>
    </perfect-scrollbar>
  </div>
</template>
<script setup>
import { ref, onMounted } from "vue";
import { usePage } from "@inertiajs/vue3";
const page = usePage();

import $ from "jquery";

const hideShow = ref(false);
const isEditor = page.props.roles.includes("EDITOR");

console.log("page", isEditor);
const mobileMenuHideShow = ref(false);

const toggleSideMenu = () => {
  hideShow.value = !hideShow.value;
  emit.emit("toggleSideMenu", hideShow.value);
};
emit.on("toggleMobileMenu", function (arg1) {
  mobileMenuHideShow.value = arg1;
});

onMounted(() => {
  $(document).ready(function () {
    $(".kt-menu__section .subMenu_new").show();
    $(".kt-menu__link").on("click", function (e) {
      $(this).parent().next(".subMenu_new").slideToggle();
      $(this).parent().toggleClass("active");
      e.preventDefault();
    });
    // $('.kt-menu__section .kt-menu__item').click(function () {
    //     if ($(this).parent().hasClass("active")) {
    //         $(this).parent().removeClass("active").find(".subMenu_new").slideUp(200);
    //     } else {
    //         $(".kt-menu__section .subMenu_new").slideUp();
    //         $(".kt-menu__section ").removeClass("active");
    //         $(this).parent().addClass("active").find(".subMenu_new").slideDown(200);
    //     }
    //     return false;
    // });
  });
});
</script>

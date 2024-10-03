<template>
  <footer class="page-footer cmn-gap">
    <div class="container">
      <div class="page-footer-address">
        <p>{{ $page.props.footerAddress?.description }}</p>
      </div>
      <div class="page-footer-nav">
        <ul>
          <li
            :class="
              $page.props.current_url == 'about' ? 'current-menu-item' : ''
            "
          >
            <a href="/about">About</a>
          </li>
          <li>
            <Link href="/#faq">FAQs</Link>
          </li>
          <li
            :class="
              $page.props.current_url == 'contact' ? 'current-menu-item' : ''
            "
          >
            <a href="/contact">Contact</a>
          </li>

          <li
            :class="{
              'current-menu-item': $page.component.startsWith('Frontend/Blog'),
            }"
          >
            <a :href="route('frontend.blogs')">Blogs</a>
          </li>
          <li
            :class="
              $page.props.current_url == 'manage-subscription'
                ? 'current-menu-item'
                : ''
            "
          >
            <a href="/manage-subscription">Manage Subscription</a>
          </li>
          <li><a href="/money-back-guarantee">Money-Back Guarantee</a></li>
          <li
            :class="
              $page.props.current_url == 'terms-use' ? 'current-menu-item' : ''
            "
          >
            <a href="/terms-use">Terms & Use</a>
          </li>
          <li
            :class="
              $page.props.current_url == 'privacy-policy'
                ? 'current-menu-item'
                : ''
            "
          >
            <a href="/privacy-policy">Privacy policy</a>
          </li>
          <li
            :class="
              $page.props.current_url == 'purchase-policy'
                ? 'current-menu-item'
                : ''
            "
          >
            <a href="/purchase-policy">Purchase/Cancellation & Refund Policy</a>
          </li>
        </ul>
      </div>
      <div class="page-footer-copyright-info">
        <p>
          ©{{ new Date().getFullYear() }} <Link href="/"> MTLI</Link>. All
          rights reserved.
        </p>
      </div>
    </div>
  </footer>
</template>
<script setup></script>

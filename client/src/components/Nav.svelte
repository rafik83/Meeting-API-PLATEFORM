<style>
  nav {
    border-bottom: 1px solid rgba(255, 62, 0, 0.1);
    font-weight: 300;
    padding: 0 1em;
    display: flex;
    justify-content: space-between;
  }
  ul {
    padding: 0;
    margin: 0;
  }
  /* clearfix */
  ul::after {
    content: '';
    display: block;
    clear: both;
  }
  li {
    display: block;
    float: left;
  }
  .selected {
    position: relative;
    display: inline-block;
  }
  .selected::after {
    position: absolute;
    content: '';
    width: calc(100% - 1em);
    height: 2px;
    background-color: rgb(255, 62, 0);
    display: block;
    bottom: -1px;
  }
  a,
  .a {
    cursor: pointer;
    text-decoration: none;
    padding: 1em 0.5em;
    display: block;
  }
  .rtl {
    direction: rtl;
    display: flex;
  }
</style>

<script>
  import { _, locales } from 'svelte-i18n';
  import { stores } from '@sapper/app';
  import Link from './Link.svelte';


  const { session } = stores();
  $session.locale = 'en';
  export let segment;
</script>

<nav class={$_('direction')}>
  <ul class={$_('direction')}>
    <li>
      <a class:selected={segment === undefined} href=".">{$_('nav.home')}</a>
    </li>
    <li>
      <!-- <Link href={'about'}>{$_('nav.about')}</Link> -->
      <a
        class:selected={segment === 'about'}
        href={`${$session.locale}/about`}
      >{$_('nav.about')}</a>
    </li>
  </ul>
  <ul class="lang">
    {#each $locales as item}
      <li>
        <Link locale={item}>{$_('languages.' + item.replace('-', '_'))}</Link>
      </li>
    {/each}
  </ul>
</nav>

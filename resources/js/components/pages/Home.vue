<template>
  <app-layout>
    <alert
      :type="alertType || 'info'"
      :message="alertMessage"
      v-on:close="closeSuccessAlert"
    />
    <div class="flex flex-row justify-center">
        
      <div class="w-full sm:max-w-sm pt-5">
        <message-box
          title="ご利用にあたっての注意点"
          message="Youtube Liveを配信しているGoogleアカウントのみチャットログを取得することが可能です"
        />

        <div
          class="bg-white shadow-md rounded mt-5 mx-1 px-2 sm:px-4 pt-6 pb-8 mb-4"
          v-if="isLoggined"
        >
          <div
            v-if="video"
          >
            <video-card
              v-if="video"
              :video="video"
            />

            <chat-card
              v-for="post in posts" :key="post.id"
              :post="post"
            />

          </div>

          <div
            v-else
          >

            <div
              class="flex justify-between bg-orange-lightest border-l-4 border-orange text-orange-dark p-4"
              role="alert"
            >
              <div>
                <p class="font-bold mb-1">Live配信データ取得</p>
                <p class="text-xs">現在Live配信されているデータありません。</p>
              </div>
              <div
                class="py-1"
                @click="loadVideo"
              >
                  <svg class="fill-current h-6 w-6 text-icon hover:opacity-75" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path style="line-height:normal;text-indent:0;text-align:start;text-decoration-line:none;text-decoration-style:solid;text-decoration-color:#000;text-transform:none;block-progression:tb;isolation:auto;mix-blend-mode:normal" d="M 3.5 2 C 3.372 2 3.2444844 2.0494844 3.1464844 2.1464844 C 2.9514844 2.3414844 2.9514844 2.6585156 3.1464844 2.8535156 L 5.09375 4.8007812 C 3.1950225 6.6199194 2 9.1685121 2 12 C 2 17.511334 6.4886661 22 12 22 C 17.511334 22 22 17.511334 22 12 C 22 6.864114 18.106486 2.6175896 13.109375 2.0644531 A 1.0001 1.0001 0 0 0 13.009766 2.0585938 A 1.0001 1.0001 0 0 0 12.890625 4.0527344 C 16.891514 4.4955979 20 7.871886 20 12 C 20 16.430666 16.430666 20 12 20 C 7.5693339 20 4 16.430666 4 12 C 4 9.7105359 4.967513 7.6643975 6.5039062 6.2109375 L 8.1464844 7.8535156 C 8.3414844 8.0485156 8.6585156 8.0485156 8.8535156 7.8535156 C 8.9515156 7.7565156 9 7.628 9 7.5 L 9 3 A 1 1 0 0 0 8 2 L 3.5 2 z" font-weight="400" font-family="sans-serif" white-space="normal" overflow="visible"/></svg>
              </div>
            </div>

            <div class="text-grey text-xs mt-2">
              ブラウザをリロードするか"リフレッシュ"アイコンからデータの再取得を行ってください。
            </div>

            <div class="mt-10 text-right">
              <router-link
                to="/archives"
                class="no-underline hover:underline text-xs text-teal hover:text-grey-darkest"
              >
                過去の動画を確認する
              </router-link>
            </div>

          </div>
        </div>
        <div
          v-else
          class="text-center mt-5 pt-6 pb-8"
        >
          <google-login-button
            v-on:click="googleLogin"
          />
        </div>

      </div>

    </div>
    
  </app-layout>
</template>

<script>
import http from '~/plugins/http.js'

import Alert from '~/components/atoms/alert'
import MessageBox from '~/components/atoms/message-box'
import GoogleLoginButton from '~/components/molecules/google-login-button'
import VideoCard from '~/components/molecules/cards/video-card'
import ChatCard from '~/components/molecules/cards/chat-card'
import AppLayout from '~/components/templates/app-layout'

export default {
  components: { AppLayout, GoogleLoginButton, Alert, VideoCard, ChatCard, MessageBox },
  head: {
    title: {
      inner: process.env.MIX_APP_NAME,
    },
    meta: [
      { name: 'description', content: process.env.MIX_APP_DESCRIPTION },
    ]
  },
  data: () => ({
    form: {
        id: '',
        next_page_token: null
    },
    alertType: null,
    alertMessage: null,
    intervalId: null,
    video: null,
    posts: [],
    timerId: null,
  }),
  methods: {
    googleLogin() {
      location.href = '/oauth/google'
    },
    closeSuccessAlert() {
      this.alertMessage = null
    },
    async loadVideo() {
      if (!this.video) {
        this.$store.dispatch('setLoading', true)
      }

      const response = await http.post('api/youtube/livechats', this.form)
      this.$store.dispatch('setLoading', false)
      if (!response.ok) {
        this.alertType = 'error';
        this.alertMessage = {
          title: 'Live配信データ取得失敗',
          description: 'YoutubeのLive配信データが取得できませんでした。'
        }
        return
      }
      this.video = response.data.video
      this.form.id = this.video.v
      this.form.next_page_token = response.data.next_page_token
      this.posts = [...response.data.posts.slice().reverse(), ...this.posts]

      this.timerId = setTimeout(this.loadVideo, 5000);
    },
  },
  computed: {
    isLoggined () {
      return this.$store.getters['auth/isLoggined']
    },
    user () {
      return this.$store.getters['auth/user']
    }
  },
  created () {
    if (this.$store.getters['auth/isLoggined']) {
      this.loadVideo()
    }
  },
  beforeDestroy: function () {
    if (this.timerId) {
      clearTimeout(this.timerId);
    }
  }
}
</script>
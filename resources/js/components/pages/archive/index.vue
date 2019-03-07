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
          title="このページの説明"
          :message="description"
        />
        <div class="mb-10"></div>

        <video-card
          v-for="video in videos" :key="video.id"
          :video="video"
        />

        <div 
            v-if="next"
            class="my-10 text-center"
        >
          <button
            class="w-full bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 rounded-full"
            @click="loadVideos"
          >
            次を読み込む
          </button>
        </div>
      </div>
    </div>
    
  </app-layout>
</template>

<script>
import http from '~/plugins/http.js'

import Alert from '~/components/atoms/alert'
import MessageBox from '~/components/atoms/message-box'
import VideoCard from '~/components/molecules/cards/video-card'
import AppLayout from '~/components/templates/app-layout'


export default {
  components: { Alert, MessageBox, VideoCard, AppLayout },
  head: {
    title: function () {
      return {
        inner: this.title
      }
    },
    meta:function () {
      return [
        { id: 'description', name: 'description', content: this.description },
      ]
    }
  },
  data: () => ({
    title: 'アーカイブ',
    description: '記録した動画のアーカイブ一覧を表示します',

    next: null,
    videos: [],

    alertType: null,
    alertMessage: null,

  }),
  methods: {
    async loadVideos() {
      const response = await http.get(this.next ? `/api/videos?page=${this.next}` : '/api/videos')
      if (!response.ok) {
        this.alertType = 'error';
        this.alertMessage = {
          title: 'データ取得失敗',
          description: 'Videoデータ取得に失敗しました。'
        }
        return
      }

      this.next = response.data.next_page_url
      this.videos = [...this.videos, ...response.data.data]
    },
    closeSuccessAlert() {
      this.alertMessage = null
    },
  },
  created () {
    this.loadVideos()
  }
}
</script>
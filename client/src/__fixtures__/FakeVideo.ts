import type { Video } from '../domain';

export const buildFakeVideo = (): Video => {
  return {
    sources: [
      {
        source:
          'https://test-videos.co.uk/vids/bigbuckbunny/mp4/h264/720/Big_Buck_Bunny_720_10s_2MB.mp4',
        type: 'video/mp4',
      },
      {
        source:
          'https://test-videos.co.uk/vids/bigbuckbunny/webm/vp9/720/Big_Buck_Bunny_720_10s_2MB.webm',
        type: 'video/webm',
      },
      {
        source:
          'https://test-videos.co.uk/vids/bigbuckbunny/mkv/720/Big_Buck_Bunny_720_10s_2MB.mkv',
        type: 'video/mkv',
      },
    ],
  };
};

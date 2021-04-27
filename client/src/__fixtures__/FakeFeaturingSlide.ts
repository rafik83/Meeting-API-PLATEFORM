import type { Video } from '../domain';
import { buildFakeVideo } from './FakeVideo';

type Label = {
  title: string;
  text: string;
  link?: string;
  textButton?: string;
};

type videoFeaturingSlider = {
  video: Video;
  label: Label;
};

export const buildFakeFeaturingSlide = (): videoFeaturingSlider => {
  return {
    video: buildFakeVideo(),
    label: {
      title: 'Welcome to your space community',
      text: 'Please register to become a member',
      link: 'https://register.com',
      textButton: 'Register',
    },
  };
};

export const buildFakeFeaturingSlides = (
  numberOfSlide: number = 10
): Array<Video> => {
  let slides = [];
  for (let i = 0; i < numberOfSlide; i++) {
    slides.push(buildFakeFeaturingSlide());
  }
  return slides;
};

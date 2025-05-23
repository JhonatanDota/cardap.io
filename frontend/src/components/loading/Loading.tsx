import { Player } from '@lottiefiles/react-lottie-player';

export default function Loading() {
  return (
    <Player className="w-full md:w-1/3" autoplay loop speed={0.6} src="/images/bodymovies/loading.json" />
  );
}

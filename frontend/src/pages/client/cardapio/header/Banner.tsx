interface BannerProps {
  imageUrl: string | null;
}

export default function Banner(props: BannerProps) {
  const { imageUrl } = props;

  return (
    <div
      className="w-full h-36 md:h-52 bg-cover rounded-b-lg shadow-md"
      style={{
        backgroundImage: `url(${
          imageUrl ?? "/images/logos/CardapioLogoBlack.svg"
        })`,
      }}
    ></div>
  );
}

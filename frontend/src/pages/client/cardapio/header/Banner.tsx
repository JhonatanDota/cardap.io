interface BannerProps {
  imageUrl?: string;
}

export default function Banner(props: BannerProps) {
  const { imageUrl } = props;

  return (
    <div
      className="w-full h-36 bg-cover rounded-b-lg shadow-md"
      style={{
        backgroundImage: `url(${
          imageUrl ?? "/images/logos/CardapioLogoBlack.svg"
        })`,
      }}
    ></div>
  );
}

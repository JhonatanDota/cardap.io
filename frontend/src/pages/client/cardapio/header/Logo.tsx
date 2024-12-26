interface LogoProps {
  imageUrl: string | null;
}

export default function Logo(props: LogoProps) {
  const { imageUrl } = props;

  return (
    <img
      className="m-auto w-24 md:w-32 -mt-12 md:-mt-16 rounded-md shadow-lg"
      src={imageUrl ?? "/images/logos/CardapioMinifiedLogoBlack.svg"}
      alt="logo"
    />
  );
}

interface LogoProps {
  imageUrl?: string;
}

export default function Logo(props: LogoProps) {
  const { imageUrl } = props;

  return (
    <img
      className="m-auto w-24 -mt-12 rounded-md shadow-lg"
      src={imageUrl ?? "/images/logos/CardapioMinifiedLogoBlack.svg"}
      alt="logo"
    />
  );
}

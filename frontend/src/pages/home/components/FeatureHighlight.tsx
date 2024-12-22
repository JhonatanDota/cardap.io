interface FeatureHighlightProps {
  icon: React.ReactNode;
  title: string;
  text: string;
}

export default function FeatureHighlight(props: FeatureHighlightProps) {
  const { icon, title, text } = props;

  return (
    <div className="flex flex-col items-center gap-2">
      <svg className="w-14 md:w-20 h-14 md:h-20">{icon}</svg>
      <p className="text-2xl md:text-3xl uppercase font-bold text-orange-400">
        {title}
      </p>
      <p className="text-base md:text-xl font-semibold text-center">{text}</p>
    </div>
  );
}

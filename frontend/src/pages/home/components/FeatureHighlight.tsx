interface FeatureHighlightProps {
  icon: React.ReactNode;
  title: string;
  text: string;
}

export default function FeatureHighlight(props: FeatureHighlightProps) {
  const { icon, title, text } = props;

  return (
    <div className="flex flex-col items-center gap-2">
      <svg className="w-14 h-12">
        {icon}
      </svg>
      <p className="text-2xl uppercase font-bold text-orange-400">{title}</p>
      <p className="text-base font-semibold text-center">{text}</p>
    </div>
  );
}

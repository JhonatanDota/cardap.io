interface AdminMenuItemProps {
  name: string;
  icon: React.ReactNode;
  isExpanded: boolean;
}

export default function AdminMenuItem(props: AdminMenuItemProps) {
  const { name, icon, isExpanded } = props;

  return (
    <div className="flex items-center gap-1.5 md:gap-2 w-full h-14 md:h-20 px-5 md:px-8 rounded hover:bg-gray-700 hover:text-gray-300 overflow-hidden">
      <span className="w-6 md:w-8 min-w-6 md:min-w-8 h-6 md:h-8">{icon}</span>
      {isExpanded && (
        <span className="text-sm md:text-base font-bold">{name}</span>
      )}
    </div>
  );
}

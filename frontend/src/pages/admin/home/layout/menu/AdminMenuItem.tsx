interface AdminMenuItemProps {
  name: string;
  icon: React.ReactNode;
  isExpanded: boolean;
}

export default function AdminMenuItem(props: AdminMenuItemProps) {
  const { name, icon, isExpanded } = props;

  return (
    <div className="flex items-center gap-1 w-full h-14 px-5 mt-2 rounded hover:bg-gray-700 hover:text-gray-300 overflow-hidden">
      <span className="w-6 min-w-6 h-6">{icon}</span>
      {isExpanded && <span className="text-sm font-medium">{name}</span>}
    </div>
  );
}

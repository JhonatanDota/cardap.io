interface AdminMenuItemProps {
  name: string;
  icon: React.ReactNode;
}

export default function AdminMenuItem(props: AdminMenuItemProps) {
  const { name, icon } = props;
  return (
    <div className="flex items-center gap-2 w-full h-12 px-3 mt-2 rounded hover:bg-gray-700 hover:text-gray-300">
      <svg className="w-7 h-7">{icon}</svg>

      <span className="text-sm font-medium">{name}</span>
    </div>
  );
}

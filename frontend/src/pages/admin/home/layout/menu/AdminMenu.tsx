import { useState } from "react";

import AdminMenuItems from "./AdminMenuItems";

export default function AdminMenu() {
  const [isExpanded, setIsExpanded] = useState(false);

  return (
    <div
      className={`flex ${
        isExpanded ? "w-32" : "w-16"
      } bg-gray-900 rounded-r-md transition-all duration-300`}
    >
      <div className="flex flex-col items-center w-full text-gray-400">
        <button
          onClick={() => setIsExpanded(!isExpanded)}
          className="flex items-center justify-center w-full h-10 bg-gray-800 hover:bg-gray-700 focus:outline-none"
        >
          <svg
            className={`w-4 h-4 transition-transform duration-300 ${
              isExpanded ? "rotate-180" : ""
            }`}
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              strokeLinecap="round"
              strokeLinejoin="round"
              strokeWidth="2"
              d="M15 19l-7-7 7-7"
            />
          </svg>
        </button>

        <a
          className="flex flex-col gap-1 items-center w-full mt-2 transition-all duration-300 overflow-hidden"
          href="#"
        >
          <img
            className="w-8 h-8"
            src={"/images/logos/CardapioMinifiedLogoWhite.svg"}
            alt=""
          />
          {/* {isExpanded && <span className="text-sm font-bold">Cardap.io</span>} */}
        </a>

        <AdminMenuItems isMenuExpanded={isExpanded} />
      </div>
    </div>
  );
}

import {
  CompanyOperatingStatusEnum,
  CompanyOperatingStatusReadableEnum,
} from "../../../../enums/company";

interface OperatingStatusProps {
  operatingStatus: CompanyOperatingStatusEnum;
}

export default function OperatingStatus(props: OperatingStatusProps) {
  const { operatingStatus } = props;

  const operationStatusColorClassMap = {
    [CompanyOperatingStatusEnum.OPEN]: "text-green-600",
    [CompanyOperatingStatusEnum.CLOSED]: "text-red-500",
  };

  return (
    <h1
      className={`uppercase text-lg md:text-2xl font-medium text-center ${operationStatusColorClassMap[operatingStatus]}`}
    >
      {CompanyOperatingStatusReadableEnum[operatingStatus]}
    </h1>
  );
}

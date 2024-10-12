export default function Status({ text }) {
  let classString = null;
  let label = null;
  switch (text) {
    case "Not Registered":
      classString = "text-red-600 bg-red-100";
      label = "Not Registered";
      break;

    case "Not Scheduled":
      classString = "text-orange-600 bg-orange-100";
      label = "Not Scheduled";
      break;

    case "Scheduled":
      classString = "text-blue-600 bg-blue-100";
      label = "Scheduled";
      break;

    case "Vaccinated":
      classString = "text-green-600 bg-green-100";
      label = "Vaccinated";
      break;
  }

  return (
    <span
      className={`font-medium text-xs rounded-md py-1 px-2.5 ${classString}`}
    >
      {label}
    </span>
  );
}

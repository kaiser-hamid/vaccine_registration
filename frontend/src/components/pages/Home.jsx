import { Link } from "react-router-dom";

export default function Home() {
  return (
    <div className="flex items-center justify-center h-[480px]">
      <div className="flex flex-col gap-y-8 items-center">
        <h2 className="md:text-4xl text-3xl font-medium drop-shadow-lg text-teal-600 ">
          Vaccine Registration System
        </h2>
        <p className="italic">
          If you are not registered yet, please go to{" "}
          <Link to="/registration" className="text-blue-500 underline">
            registration
          </Link>{" "}
          page and submit a request for your vaccine
        </p>
      </div>
    </div>
  );
}

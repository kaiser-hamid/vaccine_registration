import { useState } from "react";
import Success from "../cards/Success";
import Error from "../cards/Error";
import http from "../../Axios";

export default function Registration() {
  const [formData, setFormData] = useState({
    first_name: "",
    last_name: "",
    email: "",
    nid: "",
    vaccine_center_id: "",
  });
  const [vaccineCenters, setVaccineCenters] = useState([]);
  const [isActiveActionButton, setIsActiveActionButton] = useState(false);

  const [response, setResponse] = useState({
    status: false,
    type: null,
    message: null,
  });

  const handleInputChange = ({ target: { name, value } }) => {
    setFormData((prev) => {
      return { ...prev, [name]: value };
    });
  };

  useState(() => {
    const fetchData = async () => {
      try {
        const {
          status,
          data: { data },
        } = await http.get("registration-form-helper-data");
        if (status === 200) {
          setVaccineCenters(data);
        }
      } catch (err) {
        console.log(err.message);
      }
    };
    fetchData();
  }, []);

  const getParsedFormData = () => {
    const form_data = new FormData();
    for (const item in formData) {
      form_data.append(item, formData[item]);
    }
    return form_data;
  };

  const handleSubmit = async (e) => {
    try {
      e.preventDefault();
      resetResponse();
      setIsActiveActionButton(true);
      const form_data = getParsedFormData();
      const {
        status,
        data: { message },
      } = await http.post("registration", form_data);
      if (status === 200) {
        setTimeout(() => {
          window.location.reload();
        }, 5000);
      }
      setResponse({
        status: true,
        type: status === 200 ? "success" : "error",
        message,
      });
    } catch (err) {
      console.log(err.message);
      let msg = err.message;
      if (err.response?.data?.message) {
        msg = err.response?.data?.message;
      }
      setResponse({
        status: true,
        type: "error",
        message: msg,
      });
    } finally {
      setIsActiveActionButton(false);
    }
  };

  const resetResponse = () => {
    setResponse({
      status: false,
      type: null,
      message: null,
    });
  };

  return (
    <div className="w-full md:w-[560px] p-4 mx-auto pb-40">
      <div className="border border-gray-200 rounded-lg">
        <div className="border-b p-4">
          <h2 className="text-gray-900 font-medium text-xl">
            Registration Form
          </h2>
        </div>
        <div className="px-4 pt-2 pb-8">
          <form className="flex flex-col gap-y-4" onSubmit={handleSubmit}>
            {/* Items */}
            <div className="flex flex-col gap-y-1.5">
              <label
                htmlFor="first_name"
                className="flex items-center font-medium text-gray-800"
              >
                First Name <span className="text-red-500 text-xl">*</span>
              </label>
              <div>
                <input
                  type="text"
                  name="first_name"
                  value={formData.first_name}
                  onChange={handleInputChange}
                  className="input input-bordered w-full focus:outline-none focus:border-teal-500 focus:outline-none focus:border-teal-500"
                  placeholder="Type here"
                  id="first_name"
                />
              </div>
            </div>
            {/* Items */}
            <div className="flex flex-col gap-y-1.5">
              <label
                htmlFor="last_name"
                className="flex items-center font-medium text-gray-800"
              >
                Last Name <span className="text-red-500 text-xl">*</span>
              </label>
              <div>
                <input
                  type="text"
                  name="last_name"
                  value={formData.last_name}
                  onChange={handleInputChange}
                  className="input input-bordered w-full focus:outline-none focus:border-teal-500"
                  placeholder="Type here"
                  id="last_name"
                />
              </div>
            </div>
            {/* Items */}
            <div className="flex flex-col gap-y-1.5">
              <label
                htmlFor="email"
                className="flex items-center font-medium text-gray-800"
              >
                Email <span className="text-red-500 text-xl">*</span>
              </label>
              <div>
                <input
                  type="email"
                  name="email"
                  value={formData.email}
                  onChange={handleInputChange}
                  className="input input-bordered w-full focus:outline-none focus:border-teal-500"
                  placeholder="Type here"
                  id="email"
                />
              </div>
            </div>
            {/* Items */}
            <div className="flex flex-col gap-y-1.5">
              <label
                htmlFor="nid"
                className="flex items-center font-medium text-gray-800"
              >
                NID Number <span className="text-red-500 text-xl">*</span>
              </label>
              <div>
                <input
                  type="text"
                  name="nid"
                  value={formData.nid}
                  onChange={handleInputChange}
                  className="input input-bordered w-full focus:outline-none focus:border-teal-500"
                  placeholder="Type here"
                  id="nid"
                />
              </div>
            </div>
            {/* Items */}
            <div className="flex flex-col gap-y-1.5">
              <label className="flex items-center font-medium text-gray-800">
                Vaccine Center <span className="text-red-500 text-xl">*</span>
              </label>
              <div>
                <select
                  onChange={handleInputChange}
                  name="vaccine_center_id"
                  value={formData.vaccine_center_id}
                  className="select select-bordered w-full focus:outline-none focus:border-teal-500"
                  placeholder="choose"
                >
                  <option value="">Select</option>
                  {vaccineCenters?.map((item, i) => (
                    <option key={i} value={item.value}>
                      {item.label}
                    </option>
                  ))}
                </select>
              </div>
            </div>
            {/* Items */}
            <div className="flex flex-col h-24 items-center">
              <button
                type="submit"
                className="btn btn-accent w-full text-base"
                disabled={isActiveActionButton}
              >
                Submit
              </button>
              <div>
                &nbsp;
                {response.status && response.type === "success" && (
                  <Success text={response.message} />
                )}
                &nbsp;
                {response.status && response.type === "error" && (
                  <Error text={response.message} />
                )}
              </div>
            </div>
            {/* == */}
          </form>
        </div>
      </div>
    </div>
  );
}

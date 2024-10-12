import { useState } from "react";
import Success from "../cards/Success";
import Error from "../cards/Error";
import http from "../../Axios";
import { Link } from "react-router-dom";
import Status from "../ui/Status";

export default function Search() {
  const [nid, setNid] = useState("");
  const [result, setResult] = useState({
    isVisible: false,
    status: null,
    data: null,
  });
  const [isActiveActionButton, setIsActiveActionButton] = useState(false);

  const [response, setResponse] = useState({
    status: false,
    type: null,
    message: null,
  });

  const handleInputChange = ({ target: { value } }) => {
    setNid(value);
  };

  const handleSubmit = async (e) => {
    try {
      e.preventDefault();
      resetResponse();
      resetResult();
      setIsActiveActionButton(true);
      if (!nid) return null;
      const {
        status,
        data: { data },
      } = await http.get(`registration/${nid}`);
      if (status === 200) {
        setResult({
          isVisible: true,
          status: data?.status,
          data: data,
        });
      }
    } catch (err) {
      console.log(err.message);
      if (err?.response?.status === 404) {
        setResult({
          isVisible: true,
          status: "Not Registered",
          data: null,
        });
      } else {
        let msg = err.message;
        if (err.response?.data?.message) {
          msg = err.response?.data?.message;
        }
        setResponse({
          status: true,
          type: "error",
          message: msg,
        });
      }
    } finally {
      setIsActiveActionButton(false);
    }
  };

  const resetResult = () => {
    setResult({
      isVisible: false,
      status: null,
      data: null,
    });
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
          <h2 className="text-gray-900 font-medium text-xl">Check Schedule</h2>
        </div>
        <div className="px-4 pt-2 pb-8">
          <form className="flex flex-col gap-y-4" onSubmit={handleSubmit}>
            {/* Items */}
            <div className="flex flex-col gap-y-1.5">
              <label
                htmlFor="nid"
                className="flex items-center font-medium text-gray-800"
              >
                Enter you NID Number{" "}
                <span className="text-red-500 text-xl">*</span>
              </label>
              <div>
                <input
                  type="text"
                  name="nid"
                  value={nid}
                  onChange={handleInputChange}
                  className="input input-bordered w-full focus:outline-none focus:border-teal-500"
                  placeholder="Type here"
                  id="nid"
                  required
                />
              </div>
            </div>

            {/* Items */}
            <div className="flex flex-col min-h-24 items-center">
              <button
                type="submit"
                className="btn btn-accent w-full text-base"
                disabled={isActiveActionButton}
              >
                <span>
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    x="0px"
                    y="0px"
                    width="16"
                    height="16"
                    viewBox="0 0 50 50"
                    className="text-gray-800"
                  >
                    <path
                      className="fill-current"
                      d="M 21 3 C 11.601563 3 4 10.601563 4 20 C 4 29.398438 11.601563 37 21 37 C 24.355469 37 27.460938 36.015625 30.09375 34.34375 L 42.375 46.625 L 46.625 42.375 L 34.5 30.28125 C 36.679688 27.421875 38 23.878906 38 20 C 38 10.601563 30.398438 3 21 3 Z M 21 7 C 28.199219 7 34 12.800781 34 20 C 34 27.199219 28.199219 33 21 33 C 13.800781 33 8 27.199219 8 20 C 8 12.800781 13.800781 7 21 7 Z"
                    ></path>
                  </svg>
                </span>
                <span>Search</span>
              </button>
              {result.isVisible && (
                <div className="w-full md:w-4/5 py-8">
                  <div className="flex flex-col gap-y-4">
                    <table className="table border border-slate-300">
                      <tbody>
                        <tr>
                          <td>Status:</td>
                          <td>
                            <Status text={result.status} />
                          </td>
                        </tr>
                        {result.data ? (
                          <>
                            <tr>
                              <td>Name:</td>
                              <td className="font-medium">
                                {result.data.name}
                              </td>
                            </tr>
                            <tr>
                              <td>Email:</td>
                              <td className="font-medium">
                                {result.data.email}
                              </td>
                            </tr>
                            <tr>
                              <td>Vaccination Date:</td>
                              <td className="font-medium">
                                {result.data.date}
                              </td>
                            </tr>
                          </>
                        ) : (
                          <tr>
                            <td colSpan={2}>
                              Please, goto{" "}
                              <Link
                                to="/registration"
                                className="text-blue-500 hover:text-blue-600 transition-all duration-200"
                              >
                                registration
                              </Link>{" "}
                              page and submit the form to book your vaccine
                              schedule.
                            </td>
                          </tr>
                        )}
                      </tbody>
                    </table>
                  </div>
                </div>
              )}
              <div>
                {response.status && response.type === "success" && (
                  <div className="border border-green-500 p-4 w-full h-32 flex justify-center items-center rounded-lg">
                    <Success text={response.message} />
                  </div>
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

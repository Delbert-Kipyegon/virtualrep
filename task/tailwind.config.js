/** @type {import('tailwindcss').Config} */
module.exports = {
	content: ["./**/*.{html,js,php}"],
	theme: {
		extend: {
			colors: {
				main: "#a200ff",
				var1: "#ffffff",
				"color-1": "#e91e63",
				"color-2": "#f5ae10",
				"color-3": "#09d69c",
				"bg-dark": "#2b2c2f",
				"text-color": "#ffffff",
				"text-dark": "#333333",
			},
			boxShadow: {
				custom: "0 4px 8px rgba(0, 0, 0, 0.1)",
			},
			fontFamily: {
				poppins: ["Poppins", "sans-serif"],
			},
		},
	},
	plugins: [],
};

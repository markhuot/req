# A sample Guardfile
# More info at https://github.com/guard/guard#readme

guard 'sass', :input => 'public/sass', :output => 'public/css'

guard :sprockets, minify: true, destination: 'public/js', asset_paths: ['public/javascript'] do
  watch (%r{public/javascript/*}) { "public/js/main.js" }
end

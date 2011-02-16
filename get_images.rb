#!/usr/bin/env ruby
#
# [sudo] gem install mechanize
# ruby get_images.rb
#

require 'rubygems'
require 'mechanize'

url = "http://kylemcdonald.net/happythings"

puts "Stealing Kyle's images..."

agent = Mechanize.new
3.times do |count|
  page = count + 1
  puts "\n-- page #{page} --"
  suffix = (page > 1 ? "?start=#{page*20}" : '')
  page = agent.get("#{url}#{suffix}")

  images = (page/'img').map {|x| x.attributes['src'].to_s }

  images.each do |image|
    puts image.inspect
    agent.get("#{url}/#{image}").save_as(image)
  end
end

puts "\nDone"
